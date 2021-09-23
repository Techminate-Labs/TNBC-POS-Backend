//supplier
    Route::get('/supplierList', [SupplierController::class, 'supplierList']);
    Route::get('/supplierGetById/{id}', [SupplierController::class, 'supplierGetById']);
    Route::post('/supplierCreate', [SupplierController::class, 'supplierCreate']);
    Route::put('/supplierUpdate/{id}', [SupplierController::class, 'supplierUpdate']);
    Route::delete('/supplierDelete/{id}', [SupplierController::class, 'supplierDelete']);


$categories = $request->categories;

$products = Product::when($categories, function (Builder $query, $categories) {
    return $query->whereHas('categories', function (Builder $query) use ($categories) {
        $query->whereIn('id', $categories);
    });
})->get();