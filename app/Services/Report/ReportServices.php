<?php

namespace App\Services\Report;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

//Interface
use App\Contracts\BaseRepositoryInterface;
use App\Contracts\FilterRepositoryInterface;

//Models
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;

class ReportServices{
    private $invoiceModel = Invoice::class;
    private $invoiceItemModel = InvoiceItem::class;
    private $itemModel = Item::class;

    public function __construct(){
       //
    }
    
    // daily, weekly, monthly, yearly
    // date, payment_method, invoice_id, num_of_items, sold_by, customer, subTotal, discount, tax, total, profit
    public function report($request)
    {

        return 'ok';
    }
} 