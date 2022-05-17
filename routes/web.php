<?php

use Illuminate\Support\Facades\Route;
use Axeldotdev\LaravelApiDoc\Features;
use Axeldotdev\LaravelApiDoc\Http\Controllers\ApiDocController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (! Features::enabled(Features::generatedDocumentation())) {
    Route::group([
        'domain' => config('api-doc.domain', null),
        'prefix' => config('api-doc.path'),
        'namespace' => 'Axeldotdev\LaravelApiDoc\Http\Controllers',
        'middleware' => config('api-doc.middleware.web', 'web'),
    ], function () {
        Route::get('/', [ApiDocController::class, 'show'])->name('api-doc.show');
    });
}
