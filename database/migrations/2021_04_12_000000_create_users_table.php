<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();

            $table->string('username')->unique();
            $table->string('password');
            $table->tinyInteger('role_id');

            $table->integer('organization_id')->nullable();

            $table->string('position')->nullable();
            $table->string('locale')->default('uzk');
            $table->string('avatar')->nullable();
            $table->json('mac_address')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}
