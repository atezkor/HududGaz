<?php

use Illuminate\Support\Facades\Route;

function resource($url, $controller, $name = null) {
    Route::resource($url, $controller)->names([
        'index' => $name . '.index',
        'create' => $name . '.create',
        'store' => $name . '.store',
        'edit' => $name . '.edit',
        'update' => $name . '.update',
        'destroy' => $name . '.delete',
    ]);
}

function MenuItems(): array {
    return [
        'users' => [
            'menu_id' => 1,
            'title' => "Foydalanuvchilar",
            'href' => "admin.users.index",
            'icons' => "nav-icon fas fa-users"
        ],
        'equipments' => [
            'menu_id' => 1,
            'title' => "Jihozlar",
            'href' => "admin.equipments.index",
            'icons' => "nav-icon fas fa-drafting-compass"
        ],
        'designers' => [
            'menu_id' => 1,
            'title' => "Loyihachilar",
            'href' => "admin.designers.index",
            'icons' => "nav-icon fas fa-pencil-ruler"
        ],
        'mounters' => [
            'menu_id' => 1,
            'title' => "Montajchilar",
            'href' => "admin.mounters.index",
            'icons' => "nav-icon fas fa-network-wired"
        ]
    ];
}

function MenuItemChildrens() {
    return [
        'settings' => [
            'menu_id' => 1,
            'title' => "Tashkilot haqida",
            'href' => "admin.settings",
            'icons' => "nav-icon far fa-circle"
        ],
        'regions' => [
            'menu_id' => 1,
            'title' => "Idoralar",
            'href' => "admin.regions.index",
            'icons' => "nav-icon far fa-circle"
        ],
        'statuses' => [
            'menu_id' => 1,
            'title' => "Holatlar",
            'href' => "admin.statuses.index",
            'icons' => "nav-icon far fa-circle"
        ],
        'activities' => [
            'menu_id' => 1,
            'title' => "Faoliyat turlari",
            'href' => "admin.activities.index",
            'icons' => "nav-icon far fa-circle"
        ],
        'timetable' => [
            'menu_id' => 1,
            'title' => "Ish jadvali",
            'href' => "admin.timetable",
            'icons' => "nav-icon far fa-circle"
        ]
    ];
}
