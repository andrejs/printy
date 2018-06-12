<?php

namespace App\Models;

use App\Services\QuoteService;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    public $table = 'quotes';

    protected $attributes = [
        'country' => QuoteService::DEFAULT_COUNTRY,
    ];

    public $fillable = [
        'products',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'total' => 'integer',
        'products' => 'array',
        'country' => 'string',
    ];
}
