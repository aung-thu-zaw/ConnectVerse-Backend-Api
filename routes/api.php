<?php

use App\Http\Controllers\Api\V1\Chat\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::apiResource('/user/contacts', ContactController::class);

require __DIR__.'/auth.php';
