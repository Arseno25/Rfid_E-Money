<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HttpLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'request',
        'response',
        'method',
        'ip',
        'url',
        'status_code'
    ];

    protected $casts = [
        'request' => 'array',
        'response' => 'array',
        'ip' => 'string'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
