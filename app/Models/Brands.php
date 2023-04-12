<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;


    public function item()
    {
        return $this->hasMany(Item::class, 'brand_id', 'id');
    }
}
