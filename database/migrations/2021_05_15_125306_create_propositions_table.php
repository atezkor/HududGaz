<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropositionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->integer('organ');
            $table->integer('activity_type')->default(1);
            $table->tinyInteger('build_type');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('type');
            $table->string('file')->nullable();
            $table->date('delete_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('propositions');
    }
}
