//coupon
    Route::get('/couponList', [CouponController::class, 'couponList']);
    Route::get('/couponGetById/{id}', [CouponController::class, 'couponGetById']);
    Route::post('/couponCreate', [CouponController::class, 'couponCreate']);
    Route::put('/couponUpdate/{id}', [CouponController::class, 'couponUpdate']);
    Route::delete('/couponDelete/{id}', [CouponController::class, 'couponDelete']);


$categories = $request->categories;

$products = Product::when($categories, function (Builder $query, $categories) {
    return $query->whereHas('categories', function (Builder $query) use ($categories) {
        $query->whereIn('id', $categories);
    });
})->get();