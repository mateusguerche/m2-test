<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'type',
    ];

    /**
     * TYPE constant.
     *
     * @return array
     */
    const TYPE = [
        'percentage',
        'value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function campaign()
    {
        return $this->hasMany(Campaign::class);
    }
}
