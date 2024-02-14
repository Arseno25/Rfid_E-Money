<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'customer_id',
        'balance'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function save(array $options = [])
    {
        parent::save($options);

        // Perbarui saldo pelanggan setelah topup baru dibuat
        // Update balance of the associated customer after a new topup is created
        $customer = $this->customer;
        if ($customer) {
            // Mengambil total saldo dari semua topup
            $totalTopupBalance = $customer->topups()->sum('balance');
            // Menambahkan saldo topup baru
            $customer->balance = $totalTopupBalance;
            $customer->save();
        }
    }
}
