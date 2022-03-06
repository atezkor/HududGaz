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
            $table->foreignId('proposition_id')
                ->constrained('propositions')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('tech_condition_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('mounter_id');
            $table->string('applicant');
            $table->integer('status')->default(1);
            $table->tinyInteger('organ');
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
