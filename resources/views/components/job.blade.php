@props(['job' => $job])

<a href="{{ route('companies.show', $job->company) }}" class="font-bold">{{ $job->company->name }}</a>
<span class="text-gray-600 text-sm">Start Date: {{ $job->start_date }}</span>
