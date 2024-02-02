<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetDiskController;
use App\Http\Controllers\AssetMemoryController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['as' => 'api.'], function () {
    Orion::resource('brands', BrandController::class)->only(['index', 'show']);
    Orion::resource('assets', AssetController::class)->only(['index', 'show', 'edit', 'store', 'update', 'destroy']);
    Orion::hasManyResource('assets', 'memories', AssetMemoryController::class)->only(['index', 'show', 'edit', 'store', 'update', 'destroy']);
    Orion::hasManyResource('assets', 'disks', AssetDiskController::class)->only(['index', 'show', 'edit', 'store', 'update', 'destroy']);
});
