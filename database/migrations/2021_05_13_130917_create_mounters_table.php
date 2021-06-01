<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMountersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mounters', function (Blueprint $table) {
            $table->id();
            $table->integer('rec_num');
            $table->integer('reg_num');
            $table->string('full_name');
            $table->string('short_name');
            $table->string('leader');
            $table->tinyInteger('district');
            $table->string('phone')->nullable();
            $table->string('address');
            $table->string('taxpayer_stir')->nullable();
            $table->string('legal_form')->nullable();
            $table->date('date_created');
            $table->date('date_expired');
            $table->string('given_by');
            $table->string('permission_to', 500)->nullable();
            $table->string('implement_for', 500)->nullable();
            $table->string('document')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('mounters');
    }
}
