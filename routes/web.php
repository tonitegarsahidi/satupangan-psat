<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

// Basic home routes
Route::get('/', [HomeController::class, 'index'])->name('home.checkAuth');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// Include route files
require __DIR__ . '/landing.php';
require __DIR__ . '/profiles.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/business.php';
require __DIR__ . '/settings.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/demo.php';
require __DIR__ . '/registration.php';
// Include pengawasan routes
require __DIR__ . '/pengawasan.php';


// Authentication routes
require __DIR__ . '/auth.php';

// SaaS routes (conditionally loaded)
if (config('saas.SAAS_ACTIVATED')) {
    require __DIR__ . '/saas.php';
}
