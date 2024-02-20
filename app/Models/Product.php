<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use LaracraftTech\LaravelDateScopes\DateScopes;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use DateScopes;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
        'is_enabled',
        'category_id',
    ];

    protected $casts = [
        'is_enabled' => 'bool',
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function discounts() : BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }
}
