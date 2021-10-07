//customer
    Route::get('/customerList', [CustomerController::class, 'customerList']);
    Route::get('/customerGetById/{id}', [CustomerController::class, 'customerGetById']);
    Route::post('/customerCreate', [CustomerController::class, 'customerCreate']);
    Route::put('/customerUpdate/{id}', [CustomerController::class, 'customerUpdate']);
    Route::delete('/customerDelete/{id}', [CustomerController::class, 'customerDelete']);


$categories = $request->categories;

$products = Product::when($categories, function (Builder $query, $categories) {
    return $query->whereHas('categories', function (Builder $query) use ($categories) {
        $query->whereIn('id', $categories);
    });
})->get();