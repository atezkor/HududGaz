<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;


/**** Route ****/
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

function reduced($url, $controller, $name) {
    Route::resource($url, $controller)->names([
        'index' => $name . '.index',
        'store' => $name . '.store',
        'update' => $name . '.update',
        'destroy' => $name . '.delete',
    ]);
}

/**** ~ Route ~ ****/


function getName(): string {
    return App\Models\Organization::Data()->branch_name;
}

function isPrimaryTheme(): bool {
    return in_array(request()->user()->role_id, [User::ROLE_ADMIN, User::TECHNIC, User::ENGINEER, User::DIRECTOR]);
}

function setImage(User $user): string {
    if ($user->avatar)
        return '/storage/users/' . $user->avatar;

    return '/img/avatar.svg';
}

function menuItems(): Illuminate\Database\Eloquent\Collection {
    /* @var User $user */
    $user = auth()->user();
    return App\Models\MenuItem::items($user->role_id)->get();
}

function formatDate($date, $format = 'd.m.Y'): string {
    $res = date_create($date);
    return date_format($res, $format);
}

function extendedDate($date, bool $reverse = false): string {
    $months = [
        __('organ.january'),
        __('organ.february'),
        __('organ.march'),
        __('organ.april'),
        __('organ.may'),
        __('organ.june'),
        __('organ.july'),
        __('organ.august'),
        __('organ.september'),
        __('organ.october'),
        __('organ.november'),
        __('organ.december'),
    ];

    $date = date_create($date);
    $day = date_format($date, 'j');
    $month = date_format($date, 'n');
    $year = date_format($date, 'Y');

    if ($reverse)
        return $year . '-' . __('global.year') . ' ' . $day . '-' . $months[$month - 1];
    return $day . '-' . $months[$month - 1] . ', ' . $year . '-' . __('global.year');
}
