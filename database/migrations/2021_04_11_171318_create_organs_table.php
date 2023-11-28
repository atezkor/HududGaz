<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateOrgansTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('organs', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('tin')->unique();
            $table->tinyInteger('district_id');
            $table->string('lead_engineer');
            $table->string('department_head');
            $table->string('address');
            $table->string('address_krill');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('fax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('organs');
    }
}
