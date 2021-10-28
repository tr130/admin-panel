<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_years', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('job_id')->constrained();
            $table->year('tax_year');
            $table->integer('tax_code')->default(1257);
            $table->char('ni_category', 1)->default('A');
            $table->decimal('gross_pay_to_date', 9, 2)->default(0.00);
            $table->decimal('tax_paid_to_date', 9, 2)->default(0.00);
            $table->decimal('nic_to_date', 9, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_years');
    }
}
