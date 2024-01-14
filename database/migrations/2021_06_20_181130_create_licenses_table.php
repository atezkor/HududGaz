<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('licenses', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id');
            $table->string('applicant');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('montage_id');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('district');
            $table->string('pdf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('licenses');
    }
}
