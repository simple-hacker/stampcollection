@extends('layouts.home')

@section('hero')

<div class="container mt-6 mx-auto">
    <div class="text-center rounded-t-lg">
        <h1 class="text-xl text-white font-bold bg-blue-800 px-8 py-3">{{ __('Login') }}</h1>
    </div>
    <form method="POST" action="{{ route('login') }}" class="bg-white shadow-md rounded-b-lg px-8 pt-6 pb-8 mb-4">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                {{ __('Email') }}
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" id="email" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                {{ __('Password') }}
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" id="password" type="password" name="password" placeholder="Password" required>
            @error('password')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    {{ __('Sign In') }}
            </button>
            @if (Route::has('password.request'))
                <a class="inline-block align-baseline font-bold text-sm text-blue-800 hover:text-blue-900" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </form>
</div>
@endsection
