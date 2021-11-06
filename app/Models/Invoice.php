<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function customer(){
    	return $this->belongsTo(Customer::class);
    }
    public function invoiceItem(){
    	return $this->hasMany(InvoiceItem::class);
    }
}
