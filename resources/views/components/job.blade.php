@props(['job' => $job])
<div class="job-details">
    <div class="job-title">
        <a href="{{ route('companies.show', $job->company) }}" class="font-bold">{{ $job->company->name }}</a>
        <span class="text-gray-600 text-sm">Start Date: {{ $job->start_date }}</span>
    </div>
    <div class="job-payslips">
        <form action="{{ route('payslips.show') }}" method="post">
            @csrf
            <label for="payslip_id">View payslip:</label>
            <select name="id" id="payslip_id">
                @foreach ($job->jobYears as $jobYear)
                    @if ($jobYear->payslips->count())
                        <optgroup label="{{ $jobYear->tax_year }}">
                            @foreach ($jobYear->payslips as $payslip)
                                <option value="{{ $payslip->id }}">{{ $jobYear->tax_year }} - Month {{ $payslip->payroll->month }}</option>
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>
            <button type="submit">View Payslip</button>
        </form>
    </div>
</div>

