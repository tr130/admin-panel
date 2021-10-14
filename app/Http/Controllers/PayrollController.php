<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Payslip;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function create(Company $company)
    {
        $jobs = $company->jobs;

        return view('payrolls.create', [
            'company' => $company,
            'jobs' => $jobs,
        ]);
    }

    public function store(Company $company, Request $request)
    {
        $payroll = $company->payrolls()->create($request->only('tax_year', 'month'));

        $jobs = $request->collect()->filter(function($value, $key) {
            return is_int($key);
        });

        foreach($jobs as $job_id => $hours) {
            $payslip = new Payslip;
            $payslip->payroll_id = $payroll->id;
            $payslip->job_id = $job_id;
            $payslip->hours_worked = $hours;
            $job = $payslip->job;
            $hourly_rate = $job->annual_gross / (12 * $job->contracted_hours);
            if ($hours > $job->contracted_hours) {
                $overtime_hours = $hours - $job->contracted_hours;
                $payslip->gross_pay = $job->contracted_hours * $hourly_rate + $overtime_hours * $hourly_rate * $job->overtime_rate;
            } else {
                $payslip->gross_pay = $hours * $hourly_rate;
            }
            $job->gross_pay_to_date += $payslip->gross_pay;
            $payslip->pension_payment = $job->pension && $job->gross_pay_to_date > (6240 * $payroll->month / 12) ? $payslip->gross_pay * 0.05 : 0.00;
            $job->gross_pay_to_date -= $payslip->pension_payment;

            $personal_allowance = $job->tax_code * 10 * $payroll->month / 12;
            $higher_rate_threshold = 50270 * $payroll->month / 12;
            $additional_rate_threshold = 150000 * $payroll->month / 12;

            if ($job->gross_pay_to_date <= $personal_allowance) {
                $payslip->tax_payment = 0 - $job->tax_paid_to_date;
            } elseif ($job->gross_pay_to_date <= $higher_rate_threshold) {
                $payslip->tax_payment = ($job->gross_pay_to_date - $personal_allowance) * 0.2
                                        - $job->tax_paid_to_date;
            } elseif ($job->gross_pay_to_date <= $additional_rate_threshold) {
                $payslip->tax_payment = ($higher_rate_threshold - $personal_allowance) * 0.2
                                        + ($job->gross_pay_to_date - $higher_rate_threshold) * 0.4
                                        - $job->tax_paid_to_date;
            } else {
                $payslip->tax_payment = ($higher_rate_threshold - $personal_allowance) * 0.2
                                        + ($additional_rate_threshold - $higher_rate_threshold) * 0.4
                                        + ($job->gross_pay_to_date - $additional_rate_threshold) * 0.45
                                        - $job->tax_paid_to_date;
            }

            $job->tax_paid_to_date += $payslip->tax_payment;

            $ni_lower_threshold = 797;
            $ni_upper_threshold = 4189;

            $ni_upper_rate = 0.02;

            switch($job->ni_category) {
                case 'B':
                    $ni_mid_rate = 0.0585;
                    break;
                case 'C':
                    $ni_mid_rate = 0;
                    $ni_upper_rate = 0;
                    break;
                case 'J':
                case 'Z':
                    $ni_mid_rate = 0.02;
                    break;
                default:
                    $ni_mid_rate = 0.12;
            }

            if ($payslip->gross_pay <= $ni_lower_threshold) {
                $payslip->ni_payment = 0;
            } elseif ($payslip->gross_pay <= $ni_upper_threshold) {
                $payslip->ni_payment = ($payslip->gross_pay - $ni_lower_threshold) * $ni_mid_rate;
            } else {
                $payslip->ni_payment = ($ni_upper_threshold - $ni_lower_threshold) * $ni_mid_rate
                                        + ($payslip->gross_pay - $ni_upper_threshold) * $ni_upper_rate;
            }

            $sl1_threshold = 1657;
            $sl2_threshold = 2274;
            $sl4_threshold = 2083;
            $slpg_threshold = 1750;

            if ($job->employee->SL1 && $payslip->gross_pay > $sl1_threshold) {
                $payslip->SL_UG_payment = ($payslip->gross_pay - $sl1_threshold) * 0.09;
            } elseif ($job->employee->SL4 && $payslip->gross_pay > $sl4_threshold) {
                $payslip->SL_UG_payment = ($payslip->gross_pay - $sl4_threshold) * 0.09;
            } elseif ($job->employee->SL2 && $payslip->gross_pay > $sl2_threshold) {
                $payslip->SL_UG_payment = ($payslip->gross_pay - $sl2_threshold) * 0.09;
            }

            if ($job->employee->SLPG && $payslip->gross_pay > $slpg_threshold) {
                $payslip->SL_PG_payment = ($payslip->gross_pay - $slpg_threshold) * 0.06;
            }

            $payslip->net_pay = $payslip->gross_pay
                                - $payslip->pension_payment
                                - $payslip->tax_payment
                                - $payslip->ni_payment
                                - $payslip->SL_UG_payment
                                - $payslip->SL_PG_payment;

            $job->save();
            $payslip->save();
        }
        $payroll->save();

        return back();
    }
}
