1. hasOne

2. hasMany(EquipmentType::class)<br>
``SELECT equipment_types.* FROM equipments, equipment_types WHERE equipment_types.equipment_id = equipments.id``
