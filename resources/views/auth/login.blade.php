@extends('layouts.home')

@section('hero')

<div class="container mx-auto py-4">
    <div class="text-center bg-dark rounded-t-lg">
        <h1 class="text-xl text-white font-bold px-8 py-3">{{ __('Login') }}</h1>
    </div>
    <form method="POST" action="{{ route('login') }}" class="bg-white shadow-md rounded-b-lg px-8 pt-6 pb-8">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                {{ __('Email') }}
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 border-2 @enderror" id="email" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <p class="mt-2 text-xs text-red-500 italic font-bold">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                {{ __('Password') }}
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 border-2 @enderror" id="password" type="password" name="password" placeholder="Password" required>
            @error('password')
                <p class="mt-2 text-xs text-red-500 italic font-bold">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-dark hover:bg-darker text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ __('Sign In') }}
            </button>
            @if (Route::has('password.request'))
                <a class="inline-block align-baseline font-bold text-sm text-dark hover:text-darker" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </form>
</div>
@endsection
