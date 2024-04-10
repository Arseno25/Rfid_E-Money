<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaracraftTech\LaravelDateScopes\DateScopes;

class Order extends Model
{
    use HasFactory, DateScopes;
    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'status',
        'price',
        'price_before_discount',
        'discount_amount',
        'total',
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function discount() : BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function httplog() : HasMany
    {
        return $this->hasMany(HttpLog::class);
    }
}
