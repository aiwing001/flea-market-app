<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;


Route::get('/', [ItemController::class, 'index']);
Route::get('/mypage/profile', [ProfileController::class, 'profile'])->middleware('auth');
Route::post('/mypage/profile', [ProfileController::class, 'update'])->middleware('auth');
Route::get('/item/{item_id}', [ItemController::class, 'item']);
Route::get('/item/{item_id}/purchase',[PurchaseController::class,'index'])->middleware('auth');
Route::post('/item/{item_id}/purchase',[PurchaseController::class,'store'])->middleware('auth');
Route::get('/purchase/address/{item_id}',[PurchaseController::class,'address']);
Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);
Route::post('/like/{product}', [LikeController::class,'store'])->middleware('auth');
Route::delete('/like/{product}', [LikeController::class,'destroy'])->middleware('auth');
Route::post('/comment/{item}', [CommentController::class,'store'])->middleware('auth');
Route::get('/mypage', [ProfileController::class, 'mypage'])->middleware('auth');
Route::get('/sell', [ItemController::class, 'sell'])->middleware('auth');