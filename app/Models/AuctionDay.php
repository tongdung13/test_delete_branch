<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuctionDay extends Model
{
    use HasFactory;

    protected $table = 'auction_day';

    public function item()
    {
        return $this->hasMany(Item::class, 'auction_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public static function getAuctionId()
    {
        $session_id = Session::get('ssAuctionId');
        $date_now = date('Y-m-d');
        if ($session_id) {
            $auction = DB::table('auction_day')->where('id', $session_id)->where('status', 1)->first();
            $auctionId = @$auction->id;
        } else {
            $auction = DB::table('auction_day')->where('status', 1)->first();
            $auctionId = @$auction->id;

        }
        return $auctionId;
    }
}
