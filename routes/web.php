<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\MyBookingListController;
use App\Http\Controllers\User\RoomListController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BookingListController;

use App\Http\Controllers\ChangePassController;

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('/')
    ->get('/', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'which.home'])
    ->name('user.dashboard');

Route::prefix('/')
    ->middleware(['auth', 'is.user'])
    ->group(function () {

        Route::get('/dashboard-booking-list', [UserDashboardController::class, 'dashboard_booking_list'])
            ->name('dashboard.booking-list');

        // ROOM
        Route::get('/room/json', [RoomListController::class, 'json'])
            ->name('room-list.json');

        Route::get('/room', [RoomListController::class, 'index'])
            ->name('room-list.index');

        // MY BOOKING LIST
        Route::get('/my-booking-list/json', [MyBookingListController::class, 'json'])
            ->name('my-booking-list.json');

        Route::get('/my-booking-list', [MyBookingListController::class, 'index'])
            ->name('my-booking-list.index');

        Route::get('/my-booking-list/create', [MyBookingListController::class, 'create'])
            ->name('my-booking-list.create');

        Route::post('/my-booking-list/store', [MyBookingListController::class, 'store'])
            ->name('my-booking-list.store');

        Route::put('/my-booking-list/{id}/cancel', [MyBookingListController::class, 'cancel'])
            ->name('my-booking-list.cancel');
    });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'is.admin'])
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        /*
        |--------------------------------------------------------------------------
        | USER CRUD
        |--------------------------------------------------------------------------
        */
        Route::get('/user/json', [UserController::class, 'json'])
            ->name('user.json');

        Route::get('/user/{id}/change-pass', [UserController::class, 'change_pass'])
            ->name('user.change-pass');

        Route::put('/user/{id}/update-pass', [UserController::class, 'update_pass'])
            ->name('user.update-pass');

        /*
        |--------------------------------------------------------------------------
        | ROOM
        |--------------------------------------------------------------------------
        */
        Route::get('/room/json', [RoomController::class, 'json'])
            ->name('room.json');

        /*
        |--------------------------------------------------------------------------
        | BOOKING LIST
        |--------------------------------------------------------------------------
        */
        Route::get('/booking-list/json', [BookingListController::class, 'json'])
            ->name('booking-list.json');

        Route::get('/booking-list', [BookingListController::class, 'index'])
            ->name('booking-list.index');

        Route::put('/booking-list/{id}/update/{value}', [BookingListController::class, 'update'])
            ->name('booking-list.update');

        /*
        |--------------------------------------------------------------------------
        | BOOKING LIST REPORT (PREVIEW & PDF)
        |--------------------------------------------------------------------------
        */

        // PREVIEW HTML (Sebelum cetak PDF)
        Route::get('/booking-list/preview', [BookingListController::class, 'preview'])
            ->name('booking-list.preview');

        // EXPORT / PRINT PDF
        Route::get('/booking-list/report', [BookingListController::class, 'report'])
            ->name('booking-list.report');

        /*
        |--------------------------------------------------------------------------
        | RESOURCES
        |--------------------------------------------------------------------------
        */
        Route::resources([
            'user' => UserController::class,
            'room' => RoomController::class,
        ]);
    });

/*
|--------------------------------------------------------------------------
| CHANGE PASSWORD USER & ADMIN
|--------------------------------------------------------------------------
*/

$users = ['/', 'admin'];

foreach ($users as $user) {
    Route::prefix($user)
        ->middleware(['auth'])
        ->group(function () use ($user) {

            if ($user == '/')
                $prefix = 'user';
            else
                $prefix = 'admin';

            Route::get('/change-pass', [ChangePassController::class, 'index'])
                ->name($prefix . '.change-pass.index');

            Route::put('/change-pass/update', [ChangePassController::class, 'update'])
                ->name($prefix . '.change-pass.update');
        });
}
