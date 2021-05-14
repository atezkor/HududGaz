<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\FitterController;
use App\Http\Controllers\MounterController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\StatusController;

// Authentication routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');
Route::get('/reg', [AuthController::class, 'create'])->name('create');
Route::post('/reg', [AuthController::class, 'store'])->name('store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::group(['prefix' => 'admin'], function() {
    Route::get('/', function() {return redirect('/');});

    resource('users', UserController::class, 'admin.users');
    resource('equipments', EquipmentController::class, 'admin.equipments');
    resource('designers', DesignerController::class, 'admin.designers');
    resource('mounters', MounterController::class, 'admin.mounters');
    resource('regions', RegionController::class, 'admin.regions');
    resource('fitters', FitterController::class, 'admin.fitters');

    readonly('statuses', StatusController::class, 'admin.statuses');
    reducer('activity-types', ActivityController::class, 'admin.activities');
    reducer('timetable', UserController::class, 'admin.timetable');
    Route::get('timetable', [UserController::class, 'admin.timetable'])->name('admin.timetable');

    Route::get('equipments/{equipment}/equipment-types', [EquipmentController::class, 'show'])->name('admin.equip_type');
    Route::post('equipments/{equipment}/equipment-types', [EquipmentController::class, 'add'])->name('admin.equip_type.add');
    Route::post('equipments/{equipment}/equipment-types/{type}', [EquipmentController::class, 'renew'])->name('admin.equip_type.renew');
    Route::post('equipment-types/{type}', [EquipmentController::class, 'del'])->name('admin.equip_type.del');
    Route::get('settings', [OrganizationController::class, 'index'])->name('admin.settings');
    Route::post('settings', [OrganizationController::class, 'set'])->name('admin.settings.set');
});

Route::prefix('technic')->group(function() {
    require_once 'technic.php';
});

# main route - in route distribution by to roles
Route::get('/', function() {
    if (auth()->user() == null)
        return redirect()->route('login');

    $role_name = auth()->user()->name ?? '';

    switch ($role_name) {
        case "admin": return redirect()->route('admin.users.index');
        case "region": return redirect()->route('admin.timetable');
        case "technic": return redirect()->route('admin.setting');
        case "mounter": return redirect()->route('admin.timetable.none');
        case "designer": return redirect()->route('admin.equipments.index');
        case "engineer": return redirect()->route('admin.equipments.create');
        case "director": return redirect()->route('admin.timetable.index');
    }

    return redirect()->route('login');
})->name('dashboard');
