<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_products', 'product_id', 'campaign_id');
    }
}
