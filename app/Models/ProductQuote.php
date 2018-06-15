<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuote extends Model
{
    public $table = 'product_quote';

    public $fillable = [
        'quote_id',
        'product_id',
        'quantity',
    ];

    protected $hidden = [
        'quote_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'quote_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
    ];
}
