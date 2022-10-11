@extends('layouts.app')

@section('content')
<div class="bg-white w-full flex flex-col">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="flex bg-green-100 w-100 p-4">
        <div class="flex flex-col m-2">
            <h2 class="text-4xl">All Companies</h2>
        </div>
    </div>
    <div class="flex items-stretch flex-grow">
        <div class="w-full p-3">
            <ul>
                @foreach ($companies as $company)
                <li class="my-1">
                    <a href="{{ route('companies.show', $company) }}"><i class="bi bi-building text-green-500"></i> {{ $company->name }}</a>
                    <a href="{{ $company->website }}"><i class="bi bi-globe2"></i></a>
                    <a href="mailto:{{ $company->email }}"><i class="bi bi-envelope"></i></a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
