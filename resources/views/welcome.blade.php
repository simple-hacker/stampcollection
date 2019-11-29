@extends('layouts.home')

@section('hero')
    {{-- Hero background --}}
    <div class="flex flex-col items-center justify-center text-white" style="height:25vh">
        <h1 class="text-4xl font-bold tracking-wide capitalize">Your online stamp collection.</h1>
        <h2 class="text-2al mt-4">Browse our catalogue of Great Britain stamps.</h2>
        @guest
            <div class="flex justify-between mt-8">
                <a @click.prevent="$modal.show('login', {email: 'demo@example.co.uk', password:'password'})" href="{{ route('login') }}" class="py-2 px-4 rounded-lg border-2 border-blue-700 bg-white hover:bg-gray-400 text-blue-700 text-xl font-bold mr-2">Try Demo</a>
                <a @click.prevent="$modal.show('register')" href="{{ route('register') }}" class="py-2 px-4 rounded-lg border-2 border-white bg-blue-800 hover:bg-blue-900 text-xl font-bold ml-2">Register</a>
            </div>
        @endguest
    </div>
@endsection

@section('content')
    {{-- Counters --}}
    <div class="container mx-auto mt-3 text-center text-3xl">
        <span id="usersCount" class="font-bold">{{ $usersCount }}</span> users adding <span id="collectionsCount" class="font-bold">{{ $collectionsCount }}</span> stamps in to their collection from our catalogue of <span id="stampsCount" class="font-bold">{{ $stampsCount }}</span> stamps.
    </div>

    {{-- Features --}}
    <div id="features" class="flex-grow container mx-auto mt-8 flex justify-between">
        <div class="mr-2 flex-1">
            Gif of website

        </div>
        <div class="flex flex-col ml-2 flex-1 text-lg">
            <div class="flex items-center mb-4">
                <svg id="icon-open-book" width="30" height="30" viewBox="0 0 20 20">
                    <path d="M10.595 5.196l0.446 1.371c0.369-0.316 0.835-0.599 1.441-0.795 0.59-0.192 1.111-0.3 1.582-0.362l-0.43-1.323c-0.476 0.069-1.001 0.18-1.58 0.368s-1.055 0.45-1.459 0.741zM11.522 8.051l0.446 1.371c0.369-0.316 0.835-0.599 1.441-0.795 0.59-0.192 1.111-0.3 1.582-0.362l-0.43-1.323c-0.476 0.069-1.001 0.18-1.58 0.368-0.578 0.187-1.054 0.449-1.459 0.741zM12.45 10.905l0.446 1.371c0.369-0.316 0.835-0.599 1.441-0.795 0.59-0.192 1.111-0.3 1.582-0.362l-0.43-1.323c-0.476 0.069-1.001 0.18-1.58 0.368-0.579 0.187-1.055 0.45-1.459 0.741zM5.388 13.077l0.43 1.323c0.417-0.226 0.902-0.445 1.492-0.636 0.606-0.197 1.149-0.242 1.633-0.203l-0.446-1.371c-0.499 0.002-1.038 0.070-1.615 0.257-0.579 0.188-1.069 0.406-1.494 0.63zM3.533 7.368l0.43 1.323c0.417-0.226 0.902-0.444 1.492-0.636 0.606-0.197 1.149-0.242 1.633-0.203l-0.445-1.372c-0.499 0.003-1.038 0.070-1.616 0.258-0.579 0.188-1.069 0.406-1.494 0.63zM4.46 10.223l0.43 1.323c0.417-0.226 0.902-0.445 1.492-0.636 0.606-0.197 1.149-0.242 1.633-0.203l-0.445-1.372c-0.499 0.002-1.038 0.070-1.615 0.257-0.579 0.188-1.070 0.407-1.495 0.631zM11.064 1.41c-1.723 0.56-2.623 1.752-3.053 2.559-0.822-0.4-2.25-0.835-3.973-0.275-2.523 0.82-3.969 2.627-3.969 2.627l4.095 12.587c0.126 0.387 0.646 0.477 0.878 0.143 0.499-0.719 1.46-1.658 3.257-2.242 1.718-0.558 2.969 0.054 3.655 0.578 0.272 0.208 0.662 0.060 0.762-0.268 0.252-0.827 0.907-2.040 2.61-2.593 1.799-0.585 3.129-0.389 3.956-0.1 0.385 0.134 0.75-0.242 0.625-0.629l-4.088-12.594c0 0-2.232-0.612-4.755 0.207zM10.951 15.256c-0.819-0.244-1.901-0.358-3.141 0.044-1.251 0.406-2.127 0.949-2.699 1.404l-3.245-9.982c0.358-0.358 1.187-1.042 2.662-1.521 1.389-0.451 2.528-0.065 3.279 0.378l3.144 9.677zM17.845 12.567c-0.731-0.032-1.759 0.044-3.010 0.451-1.24 0.403-2.048 1.132-2.567 1.81l-3.144-9.677c0.346-0.8 1.040-1.782 2.43-2.233 1.474-0.479 2.547-0.413 3.047-0.334l3.244 9.983z"></path>
                </svg>
                <p class="p-2">Browse our catalogue of over {{ floor($stampsCount /10) * 10 }}+ stamps.</p>
            </div>
            <div class="flex items-center mb-4">
                <svg id="icon-open-book" width="30" height="30" viewBox="0 0 20 20">
                    <path d="M16 2h-12c-1.1 0-2 0.9-2 2v12c0 1.1 0.9 2 2 2h12c1.1 0 2-0.9 2-2v-12c0-1.1-0.9-2-2-2zM15 11h-4v4h-2v-4h-4v-2h4v-4h2v4h4v2z"></path>
                </svg>
                <p class="p-2">Add as many stamps as you have in your collection.</p>
            </div>
            <div class="flex items-center mb-4">
                <svg id="icon-open-book" width="30" height="30" viewBox="0 0 32 32">
                        <path d="M2 0h12v2h-12zM18 0h12v2h-12zM29.75 10h-1.75v-8h-8v8h-8v-8h-8v8h-1.75c-1.238 0-2.25 1.012-2.25 2.25v17.5c0 1.238 1.012 2.25 2.25 2.25h9.5c1.238 0 2.25-1.012 2.25-2.25v-11.75h4v11.75c0 1.238 1.012 2.25 2.25 2.25h9.5c1.238 0 2.25-1.012 2.25-2.25v-17.5c0-1.238-1.012-2.25-2.25-2.25zM10.875 30h-7.75c-0.619 0-1.125-0.45-1.125-1s0.506-1 1.125-1h7.75c0.619 0 1.125 0.45 1.125 1s-0.506 1-1.125 1zM17 16h-2c-0.55 0-1-0.45-1-1s0.45-1 1-1h2c0.55 0 1 0.45 1 1s-0.45 1-1 1zM28.875 30h-7.75c-0.619 0-1.125-0.45-1.125-1s0.506-1 1.125-1h7.75c0.619 0 1.125 0.45 1.125 1s-0.506 1-1.125 1z"></path>
                </svg>
                <p class="p-2">Easily view what stamps are missing in your collection.</p>
            </div>
            <div class="flex items-center mb-4">
                <svg id="icon-open-book" width="30" height="30" viewBox="0 0 32 32">
                        <path d="M16 20c0-1.105 0.895-2 2-2s2 0.895 2 2c0 1.105-0.895 2-2 2s-2-0.895-2-2zM29.001 13c-0.001 0-0.001 0 0 0l-0.001-6v-3c0-1.657-1.344-3-3-3h-20.5c-3.033 0-5.5 2.468-5.5 5.5v20c0 3.032 2.467 5.5 5.5 5.5h18c3.032 0 5.5-2.468 5.5-5.5v-1.5c0 0 0 0 0.001 0 3.998-3.001 3.998-8.999 0-12zM5.5 3h20.5c0.551 0 1 0.448 1 1v6.184c-0.314-0.112-0.648-0.184-1-0.184h-0.001v-5c0-0.553-0.448-1-1-1h-21c-0.552 0-1 0.447-1 1v3.943c-0.617-0.631-0.999-1.491-0.999-2.443 0-1.933 1.566-3.5 3.5-3.5zM24.999 6h-21v-1h21v1zM24.999 7v1h-21v-1h21zM24.999 9v1h-19.499c-0.54 0-1.044-0.132-1.5-0.35v-0.65h20.999zM27 26.5c0 1.933-1.567 3.5-3.5 3.5h-18c-1.934 0-3.5-1.567-3.5-3.5v-15.761c0.951 0.787 2.171 1.261 3.5 1.261h20.5c0.551 0 1 0.448 1 1v2h-9c-2.762 0-5 2.238-5 5s2.239 5 5 5h9v1.5zM28.277 23h-10.277c-1.654 0-3-1.346-3-3s1.346-3 3-3h9c0.617-0.008 1.229-0.307 1.602-0.804 0.104-0.14 0.185-0.297 0.25-0.461 0.009-0.022 0.025-0.039 0.033-0.062 0.719 0.943 1.115 2.099 1.115 3.327 0 1.538-0.621 2.965-1.723 4z"></path>
                </svg>
                <p class="p-2">View the total value of your stamp collection.</p>
            </div>
        </div>
    </div>
@endsection