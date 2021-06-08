<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechConditionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tech_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id')->index();
            $table->string('qrcode')->nullable();
            $table->tinyInteger('organ');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tech_conditions');
    }
}
