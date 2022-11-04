<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HabboActionsController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/habbo/actions/emulador/stop',[HabboActionsController::class, 'emuladorStop'])->middleware(['auth', 'verified'])->name('habbo.actions.emulador.stop');
Route::get('/habbo/actions/emulador/start',[HabboActionsController::class, 'emuladorStart'])->middleware(['auth', 'verified'])->name('habbo.actions.emulador.start');
Route::get('/habbo/actions/emulador/restart',[HabboActionsController::class, 'emuladorRestart'])->middleware(['auth', 'verified'])->name('habbo.actions.emulador.restart');
Route::get('/habbo/actions/emulador/log',[HabboActionsController::class, 'emuladorLog'])->middleware(['auth', 'verified'])->name('habbo.actions.emulador.log');
Route::get('/habbo/actions/containers/list',[HabboActionsController::class, 'listContainers'])->middleware(['auth', 'verified'])->name('habbo.actions.containers.list');
Route::get('/habbo/actions/containers/start',[HabboActionsController::class, 'instanceStart'])->middleware(['auth', 'verified'])->name('habbo.actions.containers.start');
Route::get('/habbo/actions/containers/stop',[HabboActionsController::class, 'instanceStop'])->middleware(['auth', 'verified'])->name('habbo.actions.containers.stop');
require __DIR__.'/auth.php';
