<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidHistory extends Model
{
    use HasFactory;

    protected $table = 'bids_history';


    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    /**
     * @param $data
     */
    public function  createBidHistory($data)
    {
        BidHistory::create([
            'item_id' => $data['item_id'],
            'bid_id' => $data['id'],
            'amount' => $data['amount'],
            'member_id' => $data['member_id'],
            'buyer_id' => $data['buyer_id'],
            'status_bid' => $data['status_bid'],
            'category_id' => $data['category_id'],
            'created_at' => new \DateTime()
        ]);
    }
    // get current bid and you bid max
    public static function currentBidItem($id_item, $id_member)
    {
        $youBidMax = BidHistory::where(['item_id' => $id_item, 'member_id' => $id_member])->pluck('amount')->first();
        $data['currentBid'] = BidHistory::where('item_id', $id_item)->pluck('amount')->first();
        $data['currentYouBid'] = $youBidMax;
        return $data;
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    /**
     *
     * @param $id_item
     * @return max amount bids
     */
    public static function currentBid($id_item)
    {
        return BidHistory::where('item_id',$id_item)->orderBy('amount', 'desc')->orderBy('id', 'asc')->first();
    }
}
