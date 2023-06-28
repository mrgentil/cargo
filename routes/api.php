<?php

use App\Constant\RoleConstant;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SuperPackageController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\UserController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'roles'

], function () {
    Route::get('/', [RoleController::class, 'index']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'users'
], function () {
    Route::post('/', [UserController::class, 'store'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    Route::put('/{user}', [UserController::class, 'update'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'shippings'
], function () {
    Route::post('/', [ShippingController::class, 'store'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    Route::get('/seek-shipping', [ShippingController::class, 'seekShipping'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    Route::post('/delivered', [ShippingController::class, 'seekShipping'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    // Route::get('/', [UserController::class, 'index']);
    // Route::get('/{user}', [UserController::class, 'show'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    // Route::put('/{user}', [UserController::class, 'update'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'packages'
], function () {
    // Route::post('/', [ShippingController::class, 'store'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    Route::get('/code/{code}', [PackageController::class, 'indexByCode'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    // Route::get('/{user}', [UserController::class, 'show'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    // Route::put('/{user}', [UserController::class, 'update'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'cargos'
], function () {
    Route::post('/', [CargoController::class, 'store'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    Route::get('/', [CargoController::class, 'index']);
    // Route::get('/{user}', [UserController::class, 'show'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    // Route::put('/{user}', [UserController::class, 'update'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'towns'
], function () {
    // Route::post('/', [CargoController::class, 'store'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    Route::get('/', [TownController::class, 'index'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);;
    // Route::get('/{user}', [UserController::class, 'show'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    // Route::put('/{user}', [UserController::class, 'update'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'super-packages'
], function () {
    Route::post('/', [SuperPackageController::class, 'store'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    Route::get('/', [SuperPackageController::class, 'index'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    // Route::get('/{user}', [UserController::class, 'show'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
    // Route::put('/{user}', [UserController::class, 'update'])->middleware(['role:' . RoleConstant::SUPER_ADMIN]);
});
