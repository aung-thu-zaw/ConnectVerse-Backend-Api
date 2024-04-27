<?php

use App\Http\Controllers\Api\V1\Chat\ContactController;
use App\Http\Controllers\Api\V1\Chat\GetUserChatListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::apiResource('/user/contacts', ContactController::class);
Route::get('/user/chat-lists', GetUserChatListController::class);



require __DIR__.'/auth.php';
