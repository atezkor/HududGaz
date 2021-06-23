<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('individuals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id')->index();
            $table->string('full_name');
            $table->integer('organ');
            $table->tinyInteger('status')->default(1);
            $table->string('phone');
            $table->string('passport');
            $table->integer('stir');

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
        Schema::dropIfExists('individuals');
    }
}
