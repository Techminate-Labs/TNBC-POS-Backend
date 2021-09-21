//Brand
    Route::get('/brandList', [BrandController::class, 'brandList']);
    Route::get('/brandGetById/{id}', [BrandController::class, 'brandGetById']);
    Route::post('/brandCreate', [BrandController::class, 'brandCreate']);
    Route::put('/brandUpdate/{id}', [BrandController::class, 'brandUpdate']);
    Route::delete('/brandDelete/{id}', [BrandController::class, 'brandDelete']);
