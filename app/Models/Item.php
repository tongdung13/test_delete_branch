<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';


    public function auction_day()
    {
        return $this->belongsTo(AuctionDay::class, 'auction_id', 'id');
    }

    public function bidsHistory()
    {
        return $this->hasOne(BidHistory::class, 'item_id', 'id');
    }

    public function brands()
    {
        return $this->belongsTo('App\Models\Brands', 'brand_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}
