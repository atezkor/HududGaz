<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateApplicantsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('applicants', function(Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->foreignId('physical_applicant_id')->nullable();
            $table->foreignId('legal_applicant_id')->nullable();
            $table->foreignId('proposition_id')->nullable();
            $table->string('name');
            $table->string('tin_pin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('applicants');
    }
}
