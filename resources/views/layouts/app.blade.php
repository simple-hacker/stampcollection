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
    <div id="app" class="flex flex-col min-h-screen {{ $theme }}">
        <nav class="flex items-center justify-between p-4 mb-1 bg-darker text-white shadow">
            <div class="text-3xl font-medium">
                <a href="{{ url('/collection') }}">
                    {{ config('app.name', 'Stamp Collection') }}
                </a>
            </div>
            <div class="flex flex-1 ml-4 justify-center items-center">
                <search-bar />
            </div>
            <div class="flex ml-4 items-center">
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
                        <a href="/catalogue" class="font-medium hover:text-highlight">Catalogue</a>
                    </div>
                    <div class="mr-6">
                        <a href="/collection" class="font-medium hover:text-highlight">My Collection</a>
                    </div>
                    <div>
                        <dropdown-menu>
                            {{-- Dropdown menu button --}}
                            <template v-slot:dropdown-toggle>
                                <button class="text-white hover:text-highlight focus:text-highlight">
                                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32">
                                        <path d="M18 22.082v-1.649c2.203-1.241 4-4.337 4-7.432 0-4.971 0-9-6-9s-6 4.029-6 9c0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h28c0-4.030-5.216-7.364-12-7.918z"></path>
                                    </svg>
                                </button>
                            </template>
                            {{-- Dropdown menu items --}}
                            <template v-slot:dropdown-contents>
                                <div class="flex flex-col justify-center items-stretch bg-gray-100 text-dark z-99">
                                    <a href="{{ route('password.change') }}" class="flex p-3 my-1 font-medium hover:bg-highlight hover:text-white z-99">
                                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                                            <path d="M22 0c-5.523 0-10 4.477-10 10 0 0.626 0.058 1.238 0.168 1.832l-12.168 12.168v6c0 1.105 0.895 2 2 2h2v-2h4v-4h4v-4h4l2.595-2.595c1.063 0.385 2.209 0.595 3.405 0.595 5.523 0 10-4.477 10-10s-4.477-10-10-10zM24.996 10.004c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"></path>
                                        </svg>
                                        Change Password
                                    </a>
                                    <a href="{{ route('logout') }}" class="flex p-3 my-1 font-medium hover:bg-highlight hover:text-white z-99" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                                            <path d="M24 20v-4h-10v-4h10v-4l6 6zM22 18v8h-10v6l-12-6v-26h22v10h-2v-8h-16l8 4v18h8v-6z"></path>
                                        </svg>
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                        @csrf
                                    </form>
                                </div>
                            </template>
                        </dropdown-menu>
                    </div>
                @endguest
            </div>
        </nav>

        <main class="flex flex-1 flex-col bg-gray-100 p-3">
                
                @includeWhen($showBrowse == true, 'components.browse')

                <section id="content" class="mt-3">
                    @yield('content')
                </section>
        </main>
        <v-dialog></v-dialog>
    </div>
    @include('sweetalert::alert')
</body>
</html>
