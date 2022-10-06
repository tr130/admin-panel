@extends('layouts.app')

@section('content')

        <div class="w-full bg-white p-6">
            <ul>
                @foreach ($companies as $company)
                <li>
                    <a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a>
                </li>
                @endforeach
            </ul>
    </div>@endsection
