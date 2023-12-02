<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateMountersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mounters', function(Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('short_name');
            $table->integer('rec_num');
            $table->integer('reg_num');
            $table->string('tin')->nullable();
            $table->string('director');
            $table->tinyInteger('district_id');
            $table->string('phone')->nullable();
            $table->string('address');
            $table->date('date_registry');
            $table->date('date_expiry');
            $table->string('given_by');
            $table->string('permissions', 500)->nullable();
            $table->string('implementations', 500)->nullable();
            $table->string('license')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('mounters');
    }
}
