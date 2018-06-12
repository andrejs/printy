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

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'total' => 'integer',
        'country' => 'string',
    ];

    /**
     * Get products associated with the given quote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
