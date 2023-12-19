# HududGaz Xorazm

Arizlarni nazorat qilish tizimi

## Loyihani o&#8216;rnatish

- `composer install`
- `cp .env.example .env`
- ``create `hududgaz` database``
- `php artisan key:generate`

## Ishlatish

- ``php artisan storage:link`` - public papkasiga havola yaratish uchun. Papka config orqali sozlanishi mumkin.
- ``php artisan migrate --seed``
- ``php artisan serve``

## Kutubxonalar (majburiy)

Dastur kerakli kutubxonalar - (extensions php)

- extension=fileinfo
- extension=pdo_mysql
- extension=gd

Global funksiyani (composer.json)

 ```json bash
{
    ...
    "autoload": {
        ...,
        "files": [
            "app/helpers.php"
        ]
    },
}
```

## Kamchilik

- AuthServiceProviderda Permission::query ishlatilganligi uchun o'rnatish jarayonida bazaga murojaat bo'lgan va xatolik
  yuz bergan
- try, catch ga olindi

## Qo&#8216;shimcha

- ``composer require barryvdh/laravel-debugbar --dev`` - This is a package to integrate PHP Debug Bar with Laravel to
  register the debugbar and attach it to the output.

## Development Environment
- [Herd](https://herd.laravel.com/) Herd is a blazing fast, native Laravel and PHP development environment for macOS.

## Foydalanilgan manbalar:

- [PHP](https://www.php.net/) - A popular general-purpose scripting language that is especially suited to web
  development.
- [Laravel](https://laravel.com/docs/8.x) - The PHP Framework for Web Artisans. Laravel is a web application framework
  with expressive, elegant syntax.
- [Laravel View-Models](https://github.com/spatie/laravel-view-models) - are simple classes that take some data, and
  transform it into something usable for the view.
- [Guzzle](https://laravel.com/docs/8.x/http-client) Guzzle is a PHP HTTP client that makes it easy to send HTTP
  requests and trivial to integrate with web services.
- [Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf) At its heart, dompdf is (mostly) a CSS 2.1 compliant HTML
  layout and rendering engine written in PHP.
- [Simple QrCode](https://www.simplesoftware.io/#/docs/simple-qrcode) - is an easy to use wrapper for the popular
  Laravel framework based on the great work provided by Bacon/BaconQrCode.

Front-End

- [AdminLTE](https://adminlte.io) AdminLTE Bootstrap Admin Dashboard Template
- [SweetAlert](https://sweetalert2.github.io) A beautiful, responsive, customizable, accessible (WAI-ARIA) replacement
  for JavaScript's popup boxes. Zero dependencies.
- [Source Sans Pro](https://fonts.adobe.com/fonts/source-sans)

Voila (uala)
# Havolalar
- https://benjamincrozat.com/install-php-mac-laravel-valet
- https://www.w3docs.com/
- https://remark.js.org/
