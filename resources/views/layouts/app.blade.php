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
        <nav class="flex items-center justify-between p-4 mb-1 bg-blue-800 text-white shadow">
            <div class="text-3xl font-medium">
                <a href="{{ url('/collection') }}">
                    {{ config('app.name', 'Stamp Collection') }}
                </a>
            </div>
            <div class="flex flex-1 ml-4 justify-center items-center">
                <search-bar />
            </div>
            <div class="flex ml-4">
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
                        <a href="/catalogue">Catalogue</a>
                    </div>
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
            <div class="flex flex-col container mx-auto">
                <div class="flex flex-wrap bg-white shadow rounded py-2 px-4 mt-3 mb-3">
                    <browse-catalogue-dropdown
                        v-bind:years="{{ $years }}"
                        v-bind:year="{{ $year ?? date('Y') }}"
                    />
                </div>
                <section id="content" class="mt-3">
                    @yield('content')
                </section>
            </div>
        </main>
        <v-dialog></v-dialog>
        <collection-modal></collection-modal>
    </div>
    @include('sweetalert::alert')
</body>
</html>
