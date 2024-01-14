<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalApplicantsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('legal_applicants', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('tin')->unique();
            $table->string('phone');
            $table->string('email');
            $table->string('director');
            $table->string('director_pin_fl')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('legal_applicants');
    }
}
