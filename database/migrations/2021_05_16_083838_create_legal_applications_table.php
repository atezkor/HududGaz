<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalApplicationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('legal_applications', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('tin');
            $table->unsignedBigInteger('proposition_id')->index();
            $table->string('director');
            $table->string('director_tin');
            $table->string('email');
            $table->string('phone');

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
        Schema::dropIfExists('legal_applications');
    }
}
