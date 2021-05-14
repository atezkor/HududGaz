<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFittersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fitters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('firm_id')->index();
            $table->integer('statement_number');
            $table->string('first_name');
            $table->string('second_name');
            $table->string('last_name');
            $table->date('date_contract');
            $table->date('date_contract_end');
            $table->integer('diploma_number');
            $table->string('passport_series');
            $table->string('specialization');
            $table->string('function');
            $table->double('experience', 4);
            $table->string('document')->nullable();
            $table->timestamps();

            $table->foreign('firm_id')
                ->references('id')
                ->on('mounters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fitters');
    }
}
