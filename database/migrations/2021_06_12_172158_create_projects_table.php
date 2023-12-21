<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateProjectsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('projects', function(Blueprint $table) {
            $table->id();
            $table->foreignId('proposition_id')
                ->constrained('propositions')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('tech_condition_id');
            $table->unsignedBigInteger('designer_id');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('organ');
            $table->string('pdf')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
