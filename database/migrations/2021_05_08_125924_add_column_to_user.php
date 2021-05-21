<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUser extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('role');
            $table->string('lastname')->nullable();
            $table->string('patronymic')->nullable();
            $table->integer('organ')->nullable();
            $table->string('position')->nullable();
            $table->string('locale')->default('uzk');
            $table->string('avatar')->default('profile.png');
            $table->json('mac_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
