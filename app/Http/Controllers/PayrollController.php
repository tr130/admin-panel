<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Company;
use App\Models\Payroll;
use App\Models\Payslip;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function show(Payroll $payroll)
    {
        $payslips = $payroll->payslips()->with(['jobYear.job.employee'])->paginate()->sortBy('jobYear.job.employee.last_name');
        return view('payrolls.show', [
            'payroll' => $payroll,
            'payslips' => $payslips,
        ]);
    }

    public function form(Request $request)
    {
        $payroll = Payroll::findOrFail($request['id']);
        return redirect()->route('payrolls.show', $payroll);
    }

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
        $request->validate([
            'tax_year' => 'numeric|required',
            'month' => 'numeric|required'
        ]);
        if ($company->payrolls()->where('tax_year', $request['tax_year'])->where('month', $request['month'])->first()) {
            return redirect()->route('payrolls.create', $company)->with('fail', 'Payroll has already been run for this month.');
        }
        $payroll = $company->payrolls()->create($request->only('tax_year', 'month'));
        $calendarMonth = (3 + $payroll->month) % 12;
        $calendarYear = $payroll->tax_year;
        if ($calendarMonth <= 3) {
            $calendarYear++;
        }
        $payrollStart = Carbon::create($calendarYear, $calendarMonth, 6, 0, 0, 0);
        $payrollEnd = Carbon::create($calendarYear, $calendarMonth + 1, 5, 0, 0, 0);

        $jobs = $request->collect()->filter(function($value, $key) {
            return is_int($key);
        });

        foreach($jobs as $job_id => $hours) {
            $job = Job::FindorFail($job_id);

            if($job->start_date <= $payrollStart && (is_null($job->end_date) || $job->end_date >= $payrollEnd )) {
                $jobYear = $job->jobYears()->where('tax_year', $payroll->tax_year)->FirstOrFail();
                $payslip = new Payslip;
                $payslip->payroll_id = $payroll->id;
                $payslip->month = $payslip->payroll->month;
                $payslip->job_year_id = $jobYear->id;
                $payslip->hours_worked = $hours;
                $hourly_rate = $job->annual_gross / (12 * $job->contracted_hours);
                if ($hours > $job->contracted_hours) {
                    $overtime_hours = $hours - $job->contracted_hours;
                    $payslip->gross_pay = $job->contracted_hours * $hourly_rate + $overtime_hours * $hourly_rate * $job->overtime_rate;
                } else {
                    $payslip->gross_pay = $hours * $hourly_rate;
                }
                $jobYear->gross_pay_to_date += $payslip->gross_pay;

                //check if pension_payment
                if ($job->pension || $job->pension_optout_date >= $payrollEnd) {
                    $payslip->pension_payment = $jobYear->gross_pay_to_date > (6240 * $payroll->month / 12) ? $payslip->gross_pay * 0.05 : 0.00;
                    $jobYear->gross_pay_to_date -= $payslip->pension_payment;
                }

                $personal_allowance = $jobYear->tax_code * 10 * $payroll->month / 12;
                $higher_rate_threshold = 50270 * $payroll->month / 12;
                $additional_rate_threshold = 150000 * $payroll->month / 12;

                if ($jobYear->gross_pay_to_date <= $personal_allowance) {
                    $payslip->tax_payment = 0 - $jobYear->tax_paid_to_date;
                } elseif ($jobYear->gross_pay_to_date <= $higher_rate_threshold) {
                    $payslip->tax_payment = ($jobYear->gross_pay_to_date - $personal_allowance) * 0.2
                                            - $jobYear->tax_paid_to_date;
                } elseif ($jobYear->gross_pay_to_date <= $additional_rate_threshold) {
                    $payslip->tax_payment = ($higher_rate_threshold - $personal_allowance) * 0.2
                                            + ($jobYear->gross_pay_to_date - $higher_rate_threshold) * 0.4
                                            - $jobYear->tax_paid_to_date;
                } else {
                    $payslip->tax_payment = ($higher_rate_threshold - $personal_allowance) * 0.2
                                            + ($additional_rate_threshold - $higher_rate_threshold) * 0.4
                                            + ($jobYear->gross_pay_to_date - $additional_rate_threshold) * 0.45
                                            - $jobYear->tax_paid_to_date;
                }

                $jobYear->tax_paid_to_date += $payslip->tax_payment;

                $ni_lower_threshold = 797;
                $ni_upper_threshold = 4189;

                $ni_upper_rate = 0.02;

                switch($jobYear->ni_category) {
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

                $jobYear->nic_to_date += $payslip->ni_payment;

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

                $payslip->total_deductions = $payslip->pension_payment
                                            + $payslip->tax_payment
                                            + $payslip->ni_payment
                                            + $payslip->SL_UG_payment
                                            + $payslip->SL_PG_payment;

                $payslip->net_pay = $payslip->gross_pay
                                    - $payslip->total_deductions;

                $jobYear->save();
                $payslip->save();
            }
        }
        $payroll->save();

        return redirect()->route('companies.show', $company);
    }
}
