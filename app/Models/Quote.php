<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    public $table = 'products';

    public $fillable = [
        'total',
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
        'products' => 'array'
    ];
}
