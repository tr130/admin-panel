<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('annual_gross', 9, 2);
            $table->decimal('contracted_hours', 6, 2);
            $table->decimal('overtime_rate', 6, 2);
            $table->boolean('pension')->default(true);
            $table->date('pension_optout_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
