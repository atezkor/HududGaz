1. hasOne

2. hasMany(EquipmentType::class)<br>
``SELECT equipment_types.* FROM equipments, equipment_types WHERE equipment_types.equipment_id = equipments.id``

3. Agar orderBy ishlamasa, `config/database.php` -> `mysql` -> `'strict' => false`. Keyin php artisan config:clear - bu xotirani tozalash uchun
