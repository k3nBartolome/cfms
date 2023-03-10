<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\PermissionController;
use App\Http\Controllers\API\User\RoleController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\DateRangeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SiteController;
use App\Http\Resources\UserResource;
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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

//User Routes
Route::post('/create_user', [UserController::class, 'store']);
Route::put('/update_user/{id}', [UserController::class, 'update']);
Route::delete('/delete_user/{id}', [UserController::class, 'destroy']);
Route::get('/show_user/{id}', [UserController::class, 'show']);
Route::get('/list_user', [UserController::class, 'index']);

//Role Routes
Route::get('/list_role', [RoleController::class, 'index']);
Route::post('/create_role', [RoleController::class, 'store']);
Route::put('/update_role/{id}', [RoleController::class, 'update']);
Route::delete('/delete_role/{id}', [RoleController::class, 'destroy']);
Route::get('/show_role/{id}', [RoleController::class, 'show']);

//Permission Routes
Route::get('/list_permission', [PermissionController::class, 'index']);
Route::post('/create_permission', [PermissionController::class, 'store']);
Route::put('/update_permission/{id}', [PermissionController::class, 'update']);
Route::delete('/delete_permission/{id}', [PermissionController::class, 'destroy']);
Route::get('/show_permission/{id}', [PermissionController::class, 'show']);

//Site Routes
Route::get('sites', [SiteController::class, 'index']);
Route::get('sites/{id}', [SiteController::class, 'show']);
Route::post('sites', [SiteController::class, 'store']);
Route::put('sites/{id}', [SiteController::class, 'update']);
Route::delete('sites/{id}', [SiteController::class, 'destroy']);

//Program Routes
Route::get('programs', [ProgramController::class, 'index']);
Route::get('programs/{id}', [ProgramController::class, 'show']);
Route::post('programs', [ProgramController::class, 'store']);
Route::put('programs/{id}', [ProgramController::class, 'update']);
Route::delete('programs/{id}', [ProgramController::class, 'destroy']);

//Classes Routes
Route::get('classes', [ClassesController::class, 'index']);
Route::get('classes/{id}', [ClassesController::class, 'show']);

Route::delete('classes/{id}', [ClassesController::class, 'destroy']);
Route::get('clark', [ClassesController::class, 'clark']);
Route::get('quezoncity', [ClassesController::class, 'quezoncity']);
Route::get('bridgetowne', [ClassesController::class, 'bridgetowne']);
Route::get('makati', [ClassesController::class, 'makati']);
Route::get('moa', [ClassesController::class, 'moa']);
Route::get('dvsm', [ClassesController::class, 'dvsm']);
Route::get('dvrob', [ClassesController::class, 'dvrob']);
Route::get('dvdelta', [ClassesController::class, 'dvdelta']);
Route::get('dvcentral', [ClassesController::class, 'dvcentral']);
Route::get('dfc', [ClassesController::class, 'dfc']);
Route::put('classes/pushedback/{id}', [ClassesController::class, 'pushedback']);
Route::put('classes/cancel/{id}', [ClassesController::class, 'cancel']);
Route::put('classes/{id}', [ClassesController::class, 'store']);

//dateRange
Route::get('daterange', [DateRangeController::class, 'index']);
