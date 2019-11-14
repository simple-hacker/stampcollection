<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="flex flex-col min-h-screen">
        <nav class="flex items-center justify-between p-4 mb-1 shadow">
            <div class="text-3xl font-medium text-grey-300">
                <a href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div class="flex">
                @guest
                    <div class="mr-4">
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    </div>
                    @if (Route::has('register'))
                        <div>
                            <a href="{{ route('register') }}">{{ __('Register') }}</a>
                        </div>
                    @endif
                @else
                    <div class="mr-6">
                        <a href="/collection">My Collection</a>
                    </div>
                    <div>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>
        </nav>

        <main class="flex flex-1 bg-gray-100">
            <div class="flex flex-col w-full">
                {{-- <section id="search" class="flex justify-center w-full">
                    <input type="text" class="p-4 m-4 w-3/4 bg-white shadow rounded" placeholder="Search for stamps or issues">
                </section> --}}
                <div class="flex items-start justify-between mt-3">
                    <section id="content" class="w-3/4 mx-auto p-4 bg-white rounded shadow">
                        @yield('content')
                    </section>
                    <aside id="browse" class="w-1/5 mx-auto p-4 bg-white rounded shadow">
                        <h2 class="text-2xl border-b p-1 mb-2">Browse stamps by year</h2>
                        <div class="flex flex-wrap mx-auto">
                            @forelse ($years as $year)
                                <a href="/browse/{{ $year }}" class="hover:underline p-1">{{ $year }}</a>
                            @empty
                                <p>The application has not generated any years.</p>
                            @endforelse
                        </div>
                    </aside>
                </div>
            </div>
        </main>
    </div>
    @include('sweetalert::alert')
</body>
</html>
