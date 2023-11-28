<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateDesignersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('designers', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('director');
            $table->string('address');
            $table->string('address_krill')->nullable();
            $table->string('phone');
            $table->date('date_reg');
            $table->date('date_end');
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
        Schema::dropIfExists('designers');
    }
}
