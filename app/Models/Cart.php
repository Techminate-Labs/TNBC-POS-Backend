<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user(){
    	return $this->hasOne(User::class);
    }

    public function cartItem(){
    	return $this->hasMany(CartItem::class);
    }
}
