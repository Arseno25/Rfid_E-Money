<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HttpLog extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'method', 'status_code', 'response', 'request'];

    protected $casts = [
        'request' => 'array',
        'response' => 'array',
    ];

    public function Order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
