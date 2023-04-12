<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }
    /**
     * Get the auctionID for the auction.
     */
    public function auctionId()
    {
        return $this->hasMany(Auction::class);
    }
}
