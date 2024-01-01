<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateTechConditionsTable extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up() {
        Schema::create('tech_conditions', function(Blueprint $table) {
            $table->id();
            $table->foreignId('proposition_id')
                ->constrained('propositions')
                ->cascadeOnDelete();
            $table->foreignId('applicant_id')->constrained('applicants');
            $table->tinyInteger('status')->default(1);
            $table->string('qrcode')->nullable();
            $table->string('pdf')->nullable();
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
