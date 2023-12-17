<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MounterController;
use App\Http\Controllers\MounterEmployeeController;
use App\Http\Controllers\OrganController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'entry'])->name('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile
Route::get('users/{user}/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::post('users/{user}/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

// Admin routes
Route::group(['prefix' => 'admin'], function() {
    Route::get('', function() {
        return redirect()->route('admin.users.index');
    });

    resource('users', UserController::class, 'admin.users');
    Route::post('user/organization/{role?}', [UserController::class, 'organization'])->name('admin.organizations-by-role');

    resource('organs', OrganController::class, 'admin.organs');
    resource('mounters/employees', MounterEmployeeController::class, 'admin.mounter.employees');
    resource('mounters', MounterController::class, 'admin.mounters');
    resource('designers', DesignerController::class, 'admin.designers');

    reducer('equipments', EquipmentController::class, 'admin.equipments');
    reducer('activity-types', ActivityController::class, 'admin.activities');

    readonly('statuses', StatusController::class, 'admin.statuses');
    resource('timetable', TimetableController::class, 'admin.timetable');

    Route::get('equipments/{equipment}/equipment-types', [EquipmentController::class, 'show'])->name('admin.equip_type');
    Route::post('equipments/{equipment}/equipment-types', [EquipmentController::class, 'add'])->name('admin.equip_type.add');
    Route::post('equipments/equipment-types/{type}', [EquipmentController::class, 'renew'])->name('admin.equip_type.renew');
    Route::post('equipment-types/{type}', [EquipmentController::class, 'remove'])->name('admin.equip_type.del');
    Route::get('settings', [OrganizationController::class, 'index'])->name('admin.settings');
    Route::post('settings', [OrganizationController::class, 'set'])->name('admin.settings.set');
});

Route::prefix('technic')->group(function() {
    require_once 'technic.php';
});

Route::prefix('district')->group(function() {
    require_once 'organ.php';
});

Route::prefix('designer')->group(function() {
    require_once 'designer.php';
});

Route::prefix('engineer')->group(function() {
    require_once 'engineer.php';
});

Route::prefix('mounter')->group(function() {
    require_once 'mounter.php';
});

Route::prefix('director')->group(function() {
    require_once 'director.php';
});

# main route - in route distribution by to roles
Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
