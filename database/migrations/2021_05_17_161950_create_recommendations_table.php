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
        Schema::create('recommendations', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id')->index();
            $table->integer('organization_id');
            $table->integer('applicant_id');
            $table->string('type', 10)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('address')->nullable();
            $table->string('access_point')->nullable();
            $table->string('gas_network')->nullable();
            $table->string('pipeline')->nullable();
            $table->string('pipe_type')->nullable();
            $table->float('length')->default(0);
            $table->float('pipe_one')->nullable();
            $table->float('pipe_two')->nullable();
            $table->float('depth')->default(0);
            $table->float('capability')->default(0);
            $table->float('pressure_win')->default(0);
            $table->float('pressure_sum')->default(0);
            $table->string('grc')->nullable();
            $table->float('consumption')->nullable();
            $table->string('pdf')->nullable();
            $table->string('comment')->nullable();
            $table->text('additional')->nullable();
            $table->string('description')->nullable();
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
