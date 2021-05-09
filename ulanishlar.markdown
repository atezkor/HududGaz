### Jo&#8216;natuvchilarni (seeder) ulash
1. Seeder faylidagi ma'lumotlar bazaga yozilishi uchun **seeders** papkasidagi **DatabaseSeeder** fayliga ulash kerak <br>
    Buning uchun ushbu fayldagi **run** funksiyasinng ichiga `$this->call(UsersSeeder::class);` yoziladi.

### Mahalliylashtirish
1. `resource/lang/{folder_name}` papka yaratiladi
2. `en` papakasidagi yangi papkaga ko'chiriladi
3. Yangi ma'lumotlarni saqlash uchun yangi fayl yaratladi (table.php)

