<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermitsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('permits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_id');
            $table->unsignedBigInteger('project');
            $table->unsignedBigInteger('montage');
            $table->tinyInteger('district');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('permits');
    }
}
