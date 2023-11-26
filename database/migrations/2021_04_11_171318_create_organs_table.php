<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateOrgansTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('organs', function(Blueprint $table) {
            $table->id();
            $table->integer('org_number')->unique();
            $table->string('lead_engineer');
            $table->string('section_leader');
            $table->tinyInteger('district');
            $table->string('org_name');
            $table->string('address');
            $table->string('address_krill');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('organs');
    }
}
