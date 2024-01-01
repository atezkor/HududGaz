<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCancelledPropositionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cancelled_propositions', function(Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->foreignId('applicant_id')->constrained('applicants');
            $table->foreignId('organization_id')->constrained('organs');
            $table->string('proposition')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('condition')->nullable();
            $table->string('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cancelled_propositions');
    }
}
