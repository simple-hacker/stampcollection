<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Stamp Collection') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="flex flex-col">
    <div id="app" class="flex flex-col h-full">
        {{-- Navbar --}}
        <nav class="p-4 bg-blue-900 text-white">
            <div class="container mx-auto flex justify-between">
                <div class="text-3xl font-medium">
                    <a href="{{ url('/collection') }}">
                        {{ config('app.name', 'Stamp Collection') }}
                    </a>
                </div>
                <div>
                    <a href="{{ route('login') }}" class="py-2 px-4 rounded-lg border-2 border-blue-700 bg-white hover:bg-gray-400 text-blue-700 text-xl font-bold mr-2">Login</a>
                </div>
            </div>
        </nav>

        {{-- Hero section --}}
        <div class="bg-blue-900">
            @yield('hero')
        </div>

        {{-- SVG waves for hero --}}
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#2a4365" fill-opacity="0.8" d="M0,96L80,96C160,96,320,96,480,106.7C640,117,800,139,960,154.7C1120,171,1280,181,1360,186.7L1440,192L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
                <path fill="#2a4365" fill-opacity="0.8" d="M0,64L80,80C160,96,320,128,480,128C640,128,800,96,960,112C1120,128,1280,192,1360,224L1440,256L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
                <path fill="#2a4365" fill-opacity="0.8" d="M0,32L80,58.7C160,85,320,139,480,170.7C640,203,800,213,960,224C1120,235,1280,245,1360,250.7L1440,256L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
                <path fill="#2a4365" fill-opacity="0.8" d="M0,192L80,208C160,224,320,256,480,240C640,224,800,160,960,122.7C1120,85,1280,75,1360,69.3L1440,64L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
            </svg>
        </div>

        {{-- Content under svg hero --}}
        @yield('content')
        
        {{-- Footer --}}
        <footer class="mt-4 bg-blue-800">
            <div class="container mx-auto p-3 text-center text-white">
                Copyright &copy; 2019 Michael Perks
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/countUp.js') }}" type="module"></script>
    <script src="{{ asset('js/welcome.js') }}" type="module"></script>
</body>

</html>