@extends('layouts.home')

@section('hero')

<div class="w-1/3 mx-auto py-4">
    <div class="text-center bg-dark rounded-t-lg">
        <h1 class="text-xl text-white font-bold px-8 py-3">{{ __('Reset Password') }}</h1>
    </div>
    @if (session('status'))
        <div class="w-1/2 mx-auto bg-green-200 border border-green-500" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}" class="bg-white shadow-md rounded-b-lg px-8 pt-6 pb-8">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                {{ __('Email') }}
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" id="email" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <p class="mt-2 text-xs text-red-500 italic font-bold">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-dark hover:bg-darker text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </form>
</div>

@endsection