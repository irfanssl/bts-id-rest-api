<?php
use Illuminate\Http\Request;
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

// not require to login
Route::group(['middleware' => 'api'], function ($router) {
    Route::prefix('auth')->group(function(){
        Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
        });
    });
});




// require to login
Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::prefix('auth')->group(function(){
        Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
            Route::post('me', 'me');
        });

        Route::prefix('checklist')->group(function(){
            Route::controller(App\Http\Controllers\ChecklistController::class)->group(function () {
                Route::get('/', 'getChecklist');
                Route::post('/', 'createChecklist');
                Route::delete('/{checklistId}', 'deleteChecklist');
            });

            Route::controller(App\Http\Controllers\ChecklistItemsController::class)->group(function () {
               Route::get('/{checklistId}/item', 'getChecklistItem');
               Route::post('/{checklistId}/item', 'createChecklistItem');
               Route::get('/{checklistId}/item/{itemId}', 'getItem');
               Route::put('/{checklistId}/item/{itemId}', 'updateItem');
               Route::put('/{checklistId}/item/rename/{itemId}', 'renameItem');
            });
        });
    });
});