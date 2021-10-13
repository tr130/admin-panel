@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <ul>
                @foreach ($companies as $company)
                <li>
                    <a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
