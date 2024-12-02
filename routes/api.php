<?php

use App\Http\Controllers\AzureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function(){
    // Auth::routes();
    Route::get('/login', [AzureController::class, 'handleRedirect'])->name('login');
    Route::get('/login/azure/callback', [AzureController::class, 'handleCallBack'])->name('login.azure.callback');
});
