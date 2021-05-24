<?php

use App\Models\MenuItem;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

function resource($url, $controller, $name) {
    Route::resource($url, $controller)->names([
        'index' => $name . '.index',
        'create' => $name . '.create',
        'store' => $name . '.store',
        'show' => $name . '.show',
        'edit' => $name . '.edit',
        'update' => $name . '.update',
        'destroy' => $name . '.delete',
    ]);
}

function reducer($url, $controller, $name) {
    Route::resource($url, $controller)->names([
        'index' => $name . '.index',
        'store' => $name . '.store',
        'update' => $name . '.update',
        'destroy' => $name . '.delete',
    ]);
}

function readonly($url, $controller, $name) {
    Route::resource($url, $controller)->names([
        'index' => $name . '.index',
        'edit' => $name . '.edit',
        'update' => $name . '.update'
    ]);
}

function getName(): string {
    return Cache::get('organization')->branch_name ?? "";
}

function formatDate($date, $format = 'd.m.Y'): string {
    $res = date_create($date);
    return date_format($res, $format);
}

function MenuItems(): Collection|array {
    return MenuItem::items(auth()->user())->orderBy('parent_id')->get();
}

function progressColor($percent): string {
    if ($percent > 75)
        return 'progress-bar bg-success';
    if ($percent > 25)
        return 'progress-bar bg-warning';
    if ($percent > 0)
        return 'progress-bar bg-danger';
    return 'progress-bar bg-transparent';
}

/* This is function for application term */
function term(int $limit, int $offset = 0): Collection {
    return Status::query()->offset($offset)->limit($limit - $offset)->get(['term']);
}

function roles(): array {
    return [
      1 => __('global.roles.admin'),
      2 => __('global.roles.technic'),
      3 => __('global.roles.district'),
      5 => __('global.roles.designer'),
      4 => __('global.roles.engineer'),
      6 => __('global.roles.mounter'),
    ];
}

function buildType(): array {
    return [
        1 => __('district.build_type.residential'),
        2 => __('district.build_type.non_residential')
    ];
}
