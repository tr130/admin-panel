<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('job_year_id')->constrained();
            $table->foreignId('payroll_id')->constrained()->onDelete('cascade');
            $table->integer('month');
            $table->decimal('hours_worked', 6, 2);
            $table->decimal('gross_pay', 7, 2);
            $table->decimal('pension_payment', 7, 2)->default(0.0);
            $table->decimal('tax_payment', 7, 2)->default(0.0);
            $table->decimal('ni_payment', 7, 2)->default(0.0);
            $table->decimal('SL_UG_payment', 7, 2)->default(0.0);
            $table->decimal('SL_PG_payment', 7, 2)->default(0.0);
            $table->decimal('total_deductions', 7, 2)->default(0.0);
            $table->decimal('net_pay', 7, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payslips');
    }
}
