@extends('layouts.app', ['showBrowse' => false])

@section('content')
<div class="flex flex-col rounded shadow">
    <h1 class="text-4xl bg-darker text-white p-4 text-center">Change Password</h1>
    <div class="p-2 bg-white mt-4">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf 

            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label for="current_password" class="text-gray-800 font-bold p-4">Current Password</label>
                </div>
                <div class="flex flex-col w-2/3">
                    <input id="current_password" name="current_password" type="password" placeholder="Current Password" class="w-full p-2 rounded border shadow @error('current_password') border-red-500 @enderror" required>
                    @error('current_password')
                        @component('components.error') {{ $message }} @endcomponent
                    @enderror
                </div>
            </div>

            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label for="new_password" class="text-gray-800 font-bold p-4">New Password</label>
                </div>
                <div class="flex flex-col w-2/3">
                    <input id="new_password" name="new_password" type="password" placeholder="New Password" class="w-full p-2 rounded border shadow @error('new_password') border-red-500 @enderror" required>
                    @error('new_password')
                        @component('components.error') {{ $message }} @endcomponent
                    @enderror
                </div>
            </div>

            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label for="confirm_new_password" class="text-gray-800 font-bold p-4">Confirm New Password</label>
                </div>
                <div class="flex flex-col w-2/3">
                    <input id="confirm_new_password" name="confirm_new_password" type="password" placeholder="Confirm New Password" class="w-full p-2 rounded border shadow @error('confirm_new_password') border-red-500 @enderror" required>
                    @error('confirm_new_password')
                        @component('components.error') {{ $message }} @endcomponent
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-center mb-6">
                <button type="submit" class="shadow bg-darker hover:bg-dark focus:shadow-outline focus:outline-none text-white font-bold py-3 px-5 rounded">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection