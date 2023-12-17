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
            $table->unsignedBigInteger('proposition_id')->index();
            $table->string('name');
            $table->integer('tin');
            $table->string('phone');
            $table->string('email');
            $table->string('director');
            $table->string('director_pin_fl');

            $table->foreign('proposition_id')
                ->references('id')
                ->on('propositions')
                ->onDelete('cascade');
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
