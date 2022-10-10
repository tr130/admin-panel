<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/app.css" rel="stylesheet">
    <title>Admin Panel | Payslip for {{ $payslip->jobYear->job->employee->first_name }} {{ $payslip->jobYear->job->employee->last_name }}</title>
</head>
<body>
    <div class="payslip">
        <div class="payslip_header">
            <span class="payslip_header_employer">
                <span class="payslip_header_employer_employer">
                    employer
                </span>
                <span class="payslip_header_employer_name">
                    {{ $payslip->payroll->company->name }}
                </span>
            </span>
            <span class="payslip_header_payadvice">
                pay advice
            </span>
        </div>
        <div class="payslip_breakdown">
            <div class="payslip_breakdown_block">
                <div class="breakdown_header">
                    Payments
                </div>
                <div class="breakdown_table">
                    <div class="breakdown_table_column">
                        <div class="breakdown_table_column_header">description</div>
                        <div class="breakdown_table_column_content">
                            <p>Basic Pay</p>
                            <p class="total">Total Payments</p>
                        </div>
                    </div>
                    <div class="breakdown_table_column">
                        <div class="breakdown_table_column_header">hours</div>
                        <div class="breakdown_table_column_content">
                            <p>{{ $payslip->hours_worked }}</p>
                        </div>
                    </div>
                    <div class="breakdown_table_column">
                        <div class="breakdown_table_column_header">rate</div>
                        <div class="breakdown_table_column_content">
                            <p></p>
                        </div>
                    </div>
                    <div class="breakdown_table_column">
                        <div class="breakdown_table_column_header">amount</div>
                        <div class="breakdown_table_column_content">
                            <p>{{ $payslip->gross_pay }}</p>
                            <p class="total">{{ $payslip->gross_pay }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="payslip_breakdown_block">
                <div class="breakdown_header">
                    Deductions
                </div>
                <div class="breakdown_table">
                    <div class="breakdown_table_column">
                        <div class="breakdown_table_column_header">description</div>
                        <div class="breakdown_table_column_content">
                            <p>Income Tax</p>
                            <p>National Insurance</p>
                            <p>Pension</p>
                            <p>Student Loan Contribution (UG)</p>
                            <p>Student Loan Contribution (PG)</p>
                            <p class="total">Total Deductions</p>
                        </div>
                    </div>
                    <div class="breakdown_table_column">
                        <div class="breakdown_table_column_header">amount</div>
                        <div class="breakdown_table_column_content">
                            <p>{{ $payslip->tax_payment }}</p>
                            <p>{{ $payslip->ni_payment }}</p>
                            <p>{{ $payslip->pension_payment }}</p>
                            <p>{{ $payslip->SL_UG_payment }}</p>
                            <p>{{ $payslip->SL_PG_payment }}</p>
                            <p class="total">{{ $payslip->total_deductions }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="payslip_breakdown_block">
                <div class="breakdown_header">
                    Year to Date
                </div>
                <div class="breakdown_table">
                    <div class="breakdown_table_column">
                        <div class="breakdown_table_column_header">description</div>
                        <div class="breakdown_table_column_content">
                            <p>Taxable Gross Pay</p>
                            <p>Income Tax</p>
                            <p>Employee NIC</p>
                            <br>
                            <p class="ni_num">NI Number {{ $payslip->jobYear->job->employee->ni_number }}</p>
                        </div>
                    </div>
                    <div class="breakdown_table_column">
                        <div class="breakdown_table_column_header">amount</div>
                        <div class="breakdown_table_column_content">
                            <p>{{ $payslip->jobYear->gross_pay_to_date }}</p>
                            <p>{{ $payslip->jobYear->tax_paid_to_date }}</p>
                            <p>{{ $payslip->jobYear->nic_to_date }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="payslip_footer">
            <div class="payslip_footer_info">
                <div class="info_column">
                    <div class="info_column_header">period</div>
                    <div class="info_column_content">
                        <p>Mt {{ $payslip->payroll->month }}</p>
                    </div>
                </div>
                <div class="info_column">
                    <div class="info_column_header">date</div>
                    <div class="info_column_content">
                        <p>{{ Carbon\Carbon::create($payslip->payroll->tax_year, $payslip->payroll->month)->addMonths(3)->endOfMonth()->format('d/m/Y')}}</p>
                    </div>
                </div>
                <div class="info_column">
                    <div class="info_column_header">pay type</div>
                    <div class="info_column_content">
                        <p>Monthly</p>
                    </div>
                </div>
                <div class="info_column">
                    <div class="info_column_header">tax code</div>
                    <div class="info_column_content">
                        <p>{{ $payslip->jobYear->tax_code }}L</p>
                    </div>
                </div>
                <div class="info_column">
                    <div class="info_column_header">employee ref</div>
                    <div class="info_column_content">
                        <p>{{ $payslip->jobYear->job->id }}</p>
                    </div>
                </div>
                <div class="info_column">
                    <div class="info_column_header">employee name</div>
                    <div class="info_column_content">
                        <p>{{ $payslip->jobYear->job->employee->first_name }}
                           {{ $payslip->jobYear->job->employee->last_name }}</p>
                    </div>
                </div>
            </div>
            <div class="payslip_footer_net">
                <div class="info_column">
                    <div class="info_column_header">net pay</div>
                    <div class="info_column_content">
                        <p>{{ $payslip->net_pay }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
