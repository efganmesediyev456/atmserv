<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AtmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankNoteController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {

    //accounts
    Route::group(['prefix'=>'account'], function(){
        Route::post('/store', [AccountController::class, 'store'])->middleware('role:admin');
        Route::get('/', [AccountController::class, 'index']);
        Route::delete('/{account}/delete', [AccountController::class, 'destroy'])->middleware('role:admin');
    });

    //bank notes
    Route::group(['prefix'=>'bank-notes', 'middleware'=>'role:admin'], function(){
        Route::post('/store', [BankNoteController::class, 'store']);
        Route::get('/', [BankNoteController::class, 'index']);
        Route::delete('/{banknote}/delete', [BankNoteController::class, 'destroy']);
    });

    //transactions
    Route::group(['prefix'=>'transactions', 'middleware'=>'role:admin'], function(){
        Route::get('/', [TransactionController::class, 'index']);
        Route::delete('/{transaction}/delete', [TransactionController::class, 'destroy'])->middleware('role:admin');
    });

    Route::post('/atm/withdraw', [AtmController::class, 'withdraw']);
});