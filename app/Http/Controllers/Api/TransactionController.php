<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\States\Status\Inactive;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function prosesTransaksi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'qty' => 'required|numeric',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($this->generateErrorResponse("ID Belum Terdaftar atau Jumlah Barang Tidak Valid"));
        }

        $uid = $request->input('uid');
        $qty_barang = $request->input('qty');

        // Memastikan input yang valid
        $validationResult = $this->validateInput($uid, $qty_barang);
        if (!$validationResult['success']) {
            return response()->json($validationResult['response']);
        }

        // Mendapatkan data pengguna
        $user = Customer::where('uid', $uid)->first();
        if (!$user || $user->status == Inactive::$name) {
            return response()->json($this->generateErrorResponse("ID Belum Terdaftar"));
        }

        // Mendapatkan data produk
        $product = Product::find($request->input('product_id'));
        if (!$product || $product->is_enabled == 0) {
            return response()->json($this->generateErrorResponse("Produk Tidak Ditemukan"));
        }

        // Memproses transaksi
        return $this->processTransaction($user, $product, $qty_barang);
    }

    private function validateInput($uid, $qty_barang)
    {
        if (!$uid || !is_numeric($qty_barang)) {
            return [
                'success' => false,
                'response' => $this->generateErrorResponse("ID Belum Terdaftar atau Jumlah Barang Tidak Valid"),
            ];
        }

        return ['success' => true];
    }

    private function generateErrorResponse($status)
    {
        return [
            "Detail" => [
                "Status" => $status,
                "Data User" => null,
                "Total Harga" => "-",
                "Saldo Akhir" => "-",
            ],
        ];
    }

    private function processTransaction($user, $product, $qty_barang)
    {
        DB::beginTransaction();

        try {
            if ($product->stock <= 0 || !$product->is_enabled) {
                DB::rollback();
                $this->saveOrder($user, $product, $qty_barang, 'failed');
                return response()->json($this->generateErrorResponse("Produk tidak tersedia"));
            }
            
            $product->decrement('stock', $qty_barang);

            // Update saldo user
            $saldo_setelah_transaksi = $user->balance - ($product->price * $qty_barang);

            if ($saldo_setelah_transaksi <= 0) {
                DB::rollback();
                $this->saveOrder($user, $product, $qty_barang, 'failed');
                return response()->json($this->generateErrorResponse("Saldo Tidak Cukup"));
            }

            $user->balance = $saldo_setelah_transaksi;
            $user->save();

            if ($product->stock <= 0) {
                $product->update(['is_enabled' => 0]);
            }

            // Simpan data transaksi ke dalam tabel dengan status 'success'
            $this->saveOrder($user, $product, $qty_barang, 'success');

            // Berikan 3 poin kepada pengguna setiap 10.000 rupiah transaksi
            $jumlah_poin = (int) floor(($product->price * $qty_barang) / 10000) * 3;
            $user->point += $jumlah_poin;
            $user->save();

            DB::commit();

            return response()->json([
                "Detail" => [
                    "Status" => "Transaksi Sukses",
                    "Data User" => $user,
                    "Total Harga" => 'Rp.' . ($product->price * $qty_barang),
                    "Saldo Akhir" => 'Rp.' . (int)$user->balance,
                    "Total Poin" => (int)$user->point . ' poin',
                ],
            ]);
        } catch (QueryException $e) {
            DB::rollback();

            // Simpan data transaksi ke dalam tabel dengan status 'failed'
            $this->saveOrder($user, $product, $qty_barang, 'failed');

            return response()->json($this->generateErrorResponse("Terjadi Kesalahan"));
        }
    }

    private function saveOrder($user, $product, $qty_barang, $status)
{
    $transaksi = new Order([
        'customer_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => $qty_barang,
        'status' => $status,
        'price' => $product->price,
        'total' => $product->price * $qty_barang,
    ]);
    $transaksi->save();
}
}