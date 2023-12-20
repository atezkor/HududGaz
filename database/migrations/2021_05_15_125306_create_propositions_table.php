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
        Schema::create('propositions', function(Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->foreignId('organization_id')->constrained('organs');
            $table->tinyInteger('type');
            $table->tinyInteger('build_type');
            $table->integer('activity_type_id')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->string('pdf')->nullable();
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
