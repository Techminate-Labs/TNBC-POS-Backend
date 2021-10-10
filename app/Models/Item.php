<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function cartItem(){
    	return $this->hasOne(CartItem::class);
    }

    public function invoiceItem(){
    	return $this->hasOne(InvoiceItem::class);
    }
}
