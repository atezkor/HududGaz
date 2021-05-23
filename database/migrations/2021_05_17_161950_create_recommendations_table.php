<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id')->index();
            $table->tinyInteger('status')->default(1);
            $table->string('address');
            $table->string('access_point');
            $table->integer('above_len');
            $table->integer('under_len');
            $table->integer('diameter');
            $table->integer('depth');
            $table->integer('capability');
            $table->integer('real_capacity');
            $table->integer('pressure_win');
            $table->integer('pressure_sum');
            $table->string('grc');
            $table->integer('consumption');
            $table->string('description')->nullable();
            $table->text('additional')->nullable();
            $table->char('type', 10)->nullable();
            $table->string('file')->nullable();
            $table->string('comment')->nullable();
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
    public function down() {
        Schema::dropIfExists('recommendations');
    }
}
