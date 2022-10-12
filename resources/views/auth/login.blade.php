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
            <h2 class="text-4xl">Login</h2>
        </div>
    </div>
    <div class="flex items-stretch flex-grow">
        <div class="w-full p-3">
            <div class="w-4/12 bg-white p-6 m-auto">
                @if (session('status'))
                <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
                    {{ session('status') }}
                </div>
                @endif
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" placeholder="Your email"
                            class="bg-green-100 border-2 w-full p-4 rounded-lg
                            @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                        @error('email')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" placeholder="Choose a password"
                            class="bg-green-100 border-2 w-full p-4 rounded-lg
                            @error('password') border-red-500 @enderror" value="">
                        @error('password')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="mr-2">
                            <label for="remember">Remember me</label>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded font-medium w-full">Login</button>
                </form>
            </div>
            <div class="w-4/12 bg-white p-6 m-auto border-t-4">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <input type="hidden" name="email" id="email" value="trial@payroll.tr130.co.uk">
                    <input type="hidden" name="password" id="password" value="password">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded font-medium w-full">Login as trial user</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
