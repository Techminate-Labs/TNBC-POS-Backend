
country-> id Name

State -> id   country_id  stateName

City -> id   state_id  cityName


$data = DB::table('city')
	->join('state', 'state.id', '=' , 'city.state_id')
	->join('country', 'country.id', '=' , 'state.country_id')

.................................................................................
customers-> id name
invoices -> user_id customer_id
invoice_items-> invoice_id medicine_id
medicines-> id name

$data = DB::table('invoice_items')
	->join('invoices', 'invoices.id', '=' , 'invoice_items.invoice_id')
	->join('medicines', 'medicines.id', '=' , 'invoice_items.invoice_id')
	->join('customers', 'customers.id', '=' , 'invoices.customers_id')





return DB::table('variances as vari')
->where('barcode_id', 'LIKE', '%' . $request->q . '%')
->select('vari.product_id', 'vari.image', 'vari.price')
->join('products as prod', "vari.product_id", '=', 'prod.id')
->select('prod.name', "vari.id", 'vari.image', 'vari.price')->paginate(10);

return DB::table(')


// return DB::table('invoices as invoice')
        // ->where('invoice.id', '5')
        // ->select('invoice.id','invoice.customer_id','invoice.user_id','invoice.payment')                               
        // ->join('customers as customer', 'customer.id','=','invoice.customer_id')
        // ->select('invoice.id','invoice.customer_id','invoice.user_id','invoice.payment','customer.name')
        // ->leftJoin('invoice_items as items', "items.id", '=',"invoice.id")
        // ->select('invoice.id','invoice.customer_id','invoice.user_id','invoice.payment', 'items.id','items.qty', 'items.amount', 'customer.name')->get();
        // ->join('medicines as medicine', 'items.id', '=', 'medicine.id')
        // ->select('invoice.id','invoice.customer_id','invoice.user_id','invoice.payment','items.qty', 'items.amount', 'medicine.name', 'medicine.price' ,'customer.name')->get();
                                               

