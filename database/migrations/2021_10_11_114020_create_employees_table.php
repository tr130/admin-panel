<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 250)->nullable();
            $table->string('phone', 50)->nullable();
            $table->dateTime('date_of_birth');
            $table->string('ni_number');
            $table->boolean('SL1')->default(false);
            $table->boolean('SL2')->default(false);
            $table->boolean('SL4')->default(false);
            $table->boolean('SLPG')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
