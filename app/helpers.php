<?php

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
    return App\Models\Organization::Data()->branch_name;
}

function setImage($user): string {
    if ($user->avatar)
        return '/storage/users/' . $user->avatar;

    return '/img/avatar.svg';
}

function formatDate($date, $format = 'd.m.Y'): string {
    $res = date_create($date);
    return date_format($res, $format);
}

function MenuItems(): Illuminate\Database\Eloquent\Collection {
    return App\Models\MenuItem::items(auth()->user())->get();
}

/* This is function for application term */
function limit(int $status, int $offset = 0): Illuminate\Support\Collection {
    return App\Models\Status::query()->offset($offset)->limit($status - $offset)->pluck('term', 'id');
}

function limitOne(int $status): int {
    return App\Models\Status::query()->find($status)->getAttribute('term');
}

function roles(): array {
    return [
      1 => __('global.roles.admin'),
      2 => __('global.roles.technic'),
      3 => __('global.roles.district'),
      4 => __('global.roles.designer'),
      5 => __('global.roles.engineer'),
      6 => __('global.roles.mounter'),
      7 => __('global.roles.director'),
    ];
}

function districts(): array { # The reason for giving the key is to start from order 1
    return [
        1 => __('global.districts.1'),
        2 => __('global.districts.2'),
        3 => __('global.districts.3'),
        4 => __('global.districts.4'),
        5 => __('global.districts.5'),
        6 => __('global.districts.6'),
        7 => __('global.districts.7'),
        8 => __('global.districts.8'),
        9 => __('global.districts.9'),
        10 => __('global.districts.10'),
        11 => __('global.districts.11'),
        12 => __('global.districts.12'),
        13 => __('global.districts.13')
    ];
}

function extendedDate($date, bool $reverse = false): string {
    $months = [
        __('district.january'),
        __('district.february'),
        __('district.march'),
        __('district.april'),
        __('district.may'),
        __('district.june'),
        __('district.july'),
        __('district.august'),
        __('district.september'),
        __('district.october'),
        __('district.november'),
        __('district.december'),
    ];

    $date = date_create($date);
    $day = date_format($date, 'j');
    $month = date_format($date, 'n');
    $year = date_format($date, 'Y');

    if ($reverse)
        return $year . '-' . __('global.year') . ' ' . $day . '-' . $months[$month - 1];
    return $day . '-' . $months[$month - 1] . ', ' . $year . '-' . __('global.year');
}
