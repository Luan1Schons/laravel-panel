<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ChatsController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\PermissionMiddleware;

/* User Portal */
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HabboActionsController;
use App\Http\Controllers\UserPortal\HabbosPortalController;
use App\Http\Controllers\UserPortal\DashboardController as DashboardUserPortalController;

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
// Chat
Broadcast::routes();

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('welcome');

    Route::get('/checkrole', function() {
            $route = null;
            if (Auth::user()->hasRole('admin')) {
                $route = '/admin/dashboard';
            }else if(Auth::user()->hasRole('habbo')){
                $route = '/habbo/dashboard';
            }else{
                $route ='/user/dashboard';
            }
            return redirect()->intended($route);
        })->middleware(['auth'])->name('checkrole');


    // Portal
    Route::get('/portal/comprar-habbo', [PortalController::class, 'comprarHabbo'])->name('portal.comprar.habbo');
    Route::get('/portal/habbos/list', [PortalController::class, 'habbos'])->name('portal.habbos.list');
    Route::post('/portal/habbos/favorite', [PortalController::class, 'favoriteHabbo'])->name('portal.habbos.favorite');
    Route::get('messages', [ChatsController::class, 'fetchMessages']);
    Route::post('messages', [ChatsController::class, 'sendMessage']);
    Route::post('messages/remove', [ChatsController::class, 'deleteMessage']);
    Route::post('chat/bans', [ChatsController::class, 'chatBans'])->name('chat.bans');
    Route::post('messages/report', [ChatsController::class, 'reportMessage'])->name('chat.messages.report');

    Route::group(['middleware' => ['auth']], function () {

        Route::group(
            ['middleware' => ['role:user']],
            function () {
                Route::get('/dashboard', [DashboardUserPortalController::class, 'index'])->name('dashboard');
            }
        );

        Route::group(
            ['middleware' => ['role:admin']],
            function () {
                Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
                Route::get('/admin/portal', [AdminController::class, 'portal'])->name('admin.portal');
                Route::get('/admin/portal/manage/habbo', [AdminController::class, 'manageHabbo'])->name('admin.portal.manage.habbo');
                Route::get('/admin/portal/edit/habbo', [AdminController::class, 'editHabbo'])->name('admin.portal.edit.habbo');
                Route::post('/admin/portal/edit/habbo', [AdminController::class, 'updateHabbo'])->name('admin.portal.update.habbo');
                Route::post('/admin/portal/boost/habbo', [AdminController::class, 'addBoosts'])->name('admin.portal.boost.habbo');
                Route::get('/admin/portal/manage/chat', [AdminController::class, 'manageChat'])->name('admin.portal.manage.chat');
                Route::post('/admin/portal/remove/chat/report', [AdminController::class, 'deleteReport'])->name('admin.portal.remove.chat.report');
                Route::post('chat/ban', [ChatsController::class, 'banUser'])->name('chat.ban');
                Route::post('/admin/portal/chat/ban', [AdminController::class, 'banUser'])->name('admin.portal.chat.ban');
                Route::post('/admin/portal/chat/unban', [AdminController::class, 'unbanUser'])->name('admin.portal.chat.unban');
                Route::get('/admin/portal/manage/users', [AdminController::class, 'manageUsers'])->name('admin.portal.manage.users');
                Route::get('/admin/portal/create/habbo', [AdminController::class, 'createHabbo'])->name('admin.portal.create.habbo');
                Route::post('/admin/portal/habbo/store', [HabbosPortalController::class, 'store'])->name('admin.portal.habbo.store');
            }
            
        );

        Route::group(
            ['middleware' => ['role:habbo']],
            function () {
                Route::get('/habbo/dashboard', [DashboardController::class, 'index'])->name('habbo.dashboard');
                Route::get('/manage', [DashboardController::class, 'manage'])->name('manage');
                Route::get('/file-manager', [DashboardController::class, 'file_manager'])->name('filemanager');
                Route::get('/filemanager', [DashboardController::class, 'filemanager'])->name('filemanager');
                // Painel
                Route::get('/habbo/actions/emulador/stop', [HabboActionsController::class, 'emuladorStop'])->name('habbo.actions.emulador.stop');
                Route::get('/habbo/actions/emulador/start', [HabboActionsController::class, 'emuladorStart'])->name('habbo.actions.emulador.start');
                Route::get('/habbo/actions/emulador/restart', [HabboActionsController::class, 'emuladorRestart'])->name('habbo.actions.emulador.restart');
                Route::get('/habbo/actions/emulador/log', [HabboActionsController::class, 'emuladorLog'])->name('habbo.actions.emulador.log');
                Route::get('/habbo/actions/containers/list', [HabboActionsController::class, 'listContainers'])->name('habbo.actions.containers.list');
                Route::get('/habbo/actions/containers/start', [HabboActionsController::class, 'instanceStart'])->name('habbo.actions.containers.start');
                Route::get('/habbo/actions/containers/stop', [HabboActionsController::class, 'instanceStop'])->name('habbo.actions.containers.stop');
                Route::get('/habbo/actions/containers/metrics/{id}', [HabboActionsController::class, 'metricsContainer'])->name('habbo.actions.containers.metrics');
                
            }
        );

        Route::group(
            ['middleware' => ['role:user']],
            function () {
                Route::get('/user/dashboard', [DashboardUserPortalController::class, 'index'])->name('user.dashboard');
                Route::post('/portal/habbo/store', [HabbosPortalController::class, 'store'])->name('portal.habbo.store');
                Route::post('/portal/habbo/update', [HabbosPortalController::class, 'update'])->name('portal.habbo.update');
            }
        );

    });
});



require __DIR__.'/auth.php';
