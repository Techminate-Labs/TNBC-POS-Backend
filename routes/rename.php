//supplier
    Route::get('/supplierList', [SupplierController::class, 'supplierList']);
    Route::get('/supplierGetById/{id}', [SupplierController::class, 'supplierGetById']);
    Route::post('/supplierCreate', [SupplierController::class, 'supplierCreate']);
    Route::put('/supplierUpdate/{id}', [SupplierController::class, 'supplierUpdate']);
    Route::delete('/supplierDelete/{id}', [SupplierController::class, 'supplierDelete']);
