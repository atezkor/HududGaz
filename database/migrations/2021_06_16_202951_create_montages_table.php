<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMontagesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('montages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id');
            $table->unsignedBigInteger('condition');
            $table->unsignedBigInteger('project');
            $table->integer('organ');
            $table->integer('status')->default(1);
            $table->string('file')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('montages');
    }
}
