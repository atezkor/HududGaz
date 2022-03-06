## Loyihani yuklash
- `git clone https://github.com/Anvar-Avenger/HududGaz.git`
- `cd HududGaz`
- `composer install`
- .env faylini yaratilsin (.env.example ni nusxalash orqali)<br>
  ```
  DB_DATABASE=hududgaz
  DB_USERNAME=root
  DB_PASSWORD={parol}
  ```
- `hududgaz` nomli baza yaratish
- `php artisan key:generate`

## Ishlatish
- php artisan storage:link
- php artisan migrate --seed
- php artisan serve

## Kutubxonalar (majburiy)
Dastur kerakli kutubxonalar - (extensions php)
- extension=fileinfo
- extension=pdo_mysql
- extension=gd


## Kamchilik
- AuthServiceProviderda Permission::query ishlatilganligi uchun o'rnatish jarayonida bazaga murojaat bo'lgan va xatolik yuz bergan
- try, catch ga olindi

## Qo&#8216;shimcha
- composer require barryvdh/laravel-debugbar --dev
