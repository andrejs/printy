<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    public $fillable = [
        'name',
        'type',
        'color',
        'size',
        'price',
    ];

    protected $hidden = [
        'pivot'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'type' => 'string',
        'color' => 'string',
        'size' => 'size',
        'price' => 'integer',
    ];

    /**
     * Get quotes associated with the given product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quotes()
    {
        return $this->belongsToMany(Quote::class);
    }
}
