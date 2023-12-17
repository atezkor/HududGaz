<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreatePhysicalApplicantsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('physical_applicants', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id')->index();
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            $table->string('passport');
            $table->integer('tin');
            $table->bigInteger('pin_fl');

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
        Schema::dropIfExists('physical_applicants');
    }
}
