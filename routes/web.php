<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\MounterController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TimetableController;

// Authentication routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'entry'])->name('auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile
Route::get('profile/{user}/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::post('profile/{user}/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

// Admin routes
Route::group(['prefix' => 'admin'], function() {
    Route::get('', function() {
        return redirect()->route('admin.users.index');
    });

    resource('users', UserController::class, 'admin.users');
    Route::post('user/change-role/{role?}', [UserController::class, 'checkFirmOrOrgan'])->name('admin.change_role');

    resource('organs', RegionController::class, 'admin.organs');
    resource('mounters', MounterController::class, 'admin.mounters'); // resource('fitters', FitterController::class, 'admin.fitters');
    resource('designers', DesignerController::class, 'admin.designers');

    reducer('equipments', EquipmentController::class, 'admin.equipments');
    reducer('activity-types', ActivityController::class, 'admin.activities');

    readonly('statuses', StatusController::class, 'admin.statuses');
    resource('timetable', TimetableController::class, 'admin.timetable');

    Route::get('equipments/{equipment}/equipment-types', [EquipmentController::class, 'show'])->name('admin.equip_type');
    Route::post('equipments/{equipment}/equipment-types', [EquipmentController::class, 'add'])->name('admin.equip_type.add');
    Route::post('equipments/equipment-types/{type}', [EquipmentController::class, 'renew'])->name('admin.equip_type.renew');
    Route::post('equipment-types/{type}', [EquipmentController::class, 'del'])->name('admin.equip_type.del');
    Route::get('settings', [OrganizationController::class, 'index'])->name('admin.settings');
    Route::post('settings', [OrganizationController::class, 'set'])->name('admin.settings.set');
});

Route::prefix('technic')->group(function() {
    require_once 'technic.php';
});

Route::prefix('district')->group(function() {
    require_once 'district.php';
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
Route::get('/', function() {
    $user = auth()->user();
    if ($user == null)
        return redirect()->route('login');

    $role = $user->role ?? 0;
    switch ($role) {
        case 1: return redirect('/admin');
        case 2: return redirect('/technic');
        case 3: return redirect('/district');
        case 4: return redirect('/designer');
        case 5: return redirect('/engineer');
        case 6: return redirect('/mounter');
        case 7: return redirect('/director');
    }

    return redirect()->route('login');
})->name('dashboard');
