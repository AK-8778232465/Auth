<?php

use Illuminate\Support\Facades\Route;
use LaravelDaily\PermissionsUI\Controllers\RoleController;
use LaravelDaily\PermissionsUI\Controllers\PermissionController;
use LaravelDaily\PermissionsUI\Controllers\UserController;

Route::redirect(Cache::get('uid'), Cache::get('uid').'/users');

Route::group([
    'middleware' => config('permission_ui.middleware'),
    'prefix'     => Cache::get('uid'),
    'as'         => config('permission_ui.route_name_prefix')],
    function () {
        Route::resource('roles', RoleController::class)->except('show');
        Route::resource('permissions', PermissionController::class)->except('show');
        Route::resource('users', UserController::class)->only('index', 'edit', 'update');
    });
