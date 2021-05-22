<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('legals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id')->index();
            $table->integer('legal_stir');
            $table->string('legal_name');
            $table->string('leader');
            $table->string('leader_stir');
            $table->string('email');
            $table->string('phone');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

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
    public function down()
    {
        Schema::dropIfExists('legals');
    }
}
