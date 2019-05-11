<?php
Route::group(['middleware' => ['web']], function () {
    Route::get("products/{id?}", "Hosein\Products\Controllers\ProductsController@index");
    Route::get("products/{cat}/{id}", "Hosein\Products\Controllers\ProductsController@editCategory");
    Route::get("deletePCategory/{id}", "Hosein\Products\Controllers\ProductsController@deleteCategory");
    Route::post("categoryPUpdate/{id}", "Hosein\Products\Controllers\ProductsController@categoryUpdate");
    Route::post("createPCategory/{id}", "Hosein\Products\Controllers\ProductsController@createCategory");
    Route::post("createProduct", "Hosein\Products\Controllers\ProductsController@createProduct");
    Route::post("productUpdate/{id}", "Hosein\Products\Controllers\ProductsController@productUpdate");
    Route::get("editProduct/{id}", "Hosein\Products\Controllers\ProductsController@editProduct");
    Route::get("deleteProduct/{id}", "Hosein\Products\Controllers\ProductsController@deleteProduct");
});
