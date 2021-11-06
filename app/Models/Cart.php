<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded=[];

    // public function user(){
    // 	return $this->hasOne(User::class);
    // }

    public function user(){
    	return $this->belongsTo(User::class);
    }
    
    public function customer(){
    	return $this->belongsTo(Customer::class);
    }

    public function cartItem(){
    	return $this->hasMany(CartItem::class);
    }
}
