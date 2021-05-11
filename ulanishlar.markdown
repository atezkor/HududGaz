### Jo&#8216;natuvchilarni (seeder) ulash
1. Seeder faylidagi ma'lumotlar bazaga yozilishi uchun **seeders** papkasidagi **DatabaseSeeder** fayliga ulash kerak <br>
    Buning uchun ushbu fayldagi **run** funksiyasinng ichiga `$this->call(UsersSeeder::class);` yoziladi.

### Helper faylini qo'shish
1. "autoload": { <br>
       "psr-4": { <br>
            "App\\": "app/" <br>
       },<br>
           "files": [<br>
           "app/helpers.php" <br>
       ]<br>
   }
2. `composer dump-autoload`

### Mahalliylashtirish
1. `resource/lang/{folder_name}` papka yaratiladi
2. `en` papakasidagi yangi papkaga ko'chiriladi
3. Yangi ma'lumotlarni saqlash uchun yangi fayl yaratladi (table.php)

### Yangi fayllar
- Xizmatchi sinflarni `app` papkasinign ixitiyoriy joyiga yartib, undan foydalanish mumkin.
  `namespace App\{Papka nomi};` degan qo'shimha qoo'shilsa yetarli
