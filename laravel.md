## Laravel ni o'rnatish

- **composer.exe** -- composer ni yuklash olib o'rnatish
- **composer create-project laravel/laravel HududGaz** -- ilova yaratish
- **php artisan serve** -- ishlatish

## Qisqacha
<table style="width: 100%">
    <thead>
        <th>Tartib</th>
        <th>Jarayon nomi</th>
        <th>Yozuv</th>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Boshqaruvchi yaratish</td>
            <td>php artisan make:controller NameController</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Model yaratish</td>
            <td>php artisan make:model Name</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Tasdiqlovchi yaratish</td>
            <td>php artisan make:request NameRequest</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Model va uning migratsiyasi</td>
            <td>php artisan make:model Name -m</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Model, Boshqaruvchi va Tasdiqlovchini birgalikda yaratish</td>
            <td>php artisan make:model Name -mrc</td>
        </tr>
    </tbody>
</table>

## Baza bilan ishlash
1. ``php artisan migrate`` bazaga jadval yaratish
2. ``php artisan migrate:fresh`` bazadagi barcha jadvalni o'chirib qaytadan yaratish
3. ``php artisan migrate:fresh --seed`` ma'lumot joylash
4. ``php artisan migrate:seeder NamesSeeder`` Jo'natuvchi yaratish
5. ``php artisan db:seed {--class=UserSeeder}`` Jo'natuvchini ishlatish {} bu dinamik parametr
6. ``php artisan make:migration add_column_to_user --table="users"`` mavjud jadvalga ustun qo'shish (bu yerda users jadvaliga)
