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
        <nav class="p-4 bg-blue-900 text-white">
            <div class="container mx-auto flex justify-between">
                <div class="text-3xl font-medium">
                    <a href="{{ url('/collection') }}">
                        {{ config('app.name', 'Stamp Collection') }}
                    </a>
                </div>
                <div>
                    <a href="#features" class="text-lg mr-4">Features</a>
                    <a href="/login" class="py-2 px-4 rounded-lg border-2 border-blue-700 bg-white hover:bg-gray-400 text-blue-700 text-xl font-bold mr-2">Login</a>
                </div>
            </div>
        </nav>
        {{-- Hero background --}}
        <div class="flex flex-col items-center justify-center bg-blue-900 text-white" style="height:25vh">
            <h1 class="text-4xl font-bold tracking-wide capitalize">Your online stamp collection.</h1>
            <h2 class="text-2al mt-4">Browse our catalogue of Great Britain stamps.</h2>
            <div class="flex justify-between mt-8">
                <a href="/login" class="py-2 px-4 rounded-lg border-2 border-blue-700 bg-white hover:bg-gray-400 text-blue-700 text-xl font-bold mr-2">Try Demo</a>
                <a href="/register" class="py-2 px-4 rounded-lg border-2 border-white bg-blue-800 hover:bg-blue-900 text-xl font-bold ml-2">Register</a>
            </div>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#2a4365" fill-opacity="0.8" d="M0,96L80,96C160,96,320,96,480,106.7C640,117,800,139,960,154.7C1120,171,1280,181,1360,186.7L1440,192L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
                <path fill="#2a4365" fill-opacity="0.8" d="M0,64L80,80C160,96,320,128,480,128C640,128,800,96,960,112C1120,128,1280,192,1360,224L1440,256L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
                <path fill="#2a4365" fill-opacity="0.8" d="M0,32L80,58.7C160,85,320,139,480,170.7C640,203,800,213,960,224C1120,235,1280,245,1360,250.7L1440,256L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
                <path fill="#2a4365" fill-opacity="0.8" d="M0,192L80,208C160,224,320,256,480,240C640,224,800,160,960,122.7C1120,85,1280,75,1360,69.3L1440,64L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
            </svg>
        </div>
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
                    <p class="p-2">Browse our catalogue of over 1000+ stamps.</p>
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
        <dropdown-menu>
            <template v-slot:dropdown-toggle>
                <button class="flex border bg-white hover:bg-gray-100 rounded shadow px-4 py-2 mb-1">
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                        <path d="M11.366 22.564l1.291-1.807-1.414-1.414-1.807 1.291c-0.335-0.187-0.694-0.337-1.071-0.444l-0.365-2.19h-2l-0.365 2.19c-0.377 0.107-0.736 0.256-1.071 0.444l-1.807-1.291-1.414 1.414 1.291 1.807c-0.187 0.335-0.337 0.694-0.443 1.071l-2.19 0.365v2l2.19 0.365c0.107 0.377 0.256 0.736 0.444 1.071l-1.291 1.807 1.414 1.414 1.807-1.291c0.335 0.187 0.694 0.337 1.071 0.444l0.365 2.19h2l0.365-2.19c0.377-0.107 0.736-0.256 1.071-0.444l1.807 1.291 1.414-1.414-1.291-1.807c0.187-0.335 0.337-0.694 0.444-1.071l2.19-0.365v-2l-2.19-0.365c-0.107-0.377-0.256-0.736-0.444-1.071zM7 27c-1.105 0-2-0.895-2-2s0.895-2 2-2 2 0.895 2 2-0.895 2-2 2zM32 12v-2l-2.106-0.383c-0.039-0.251-0.088-0.499-0.148-0.743l1.799-1.159-0.765-1.848-2.092 0.452c-0.132-0.216-0.273-0.426-0.422-0.629l1.219-1.761-1.414-1.414-1.761 1.219c-0.203-0.149-0.413-0.29-0.629-0.422l0.452-2.092-1.848-0.765-1.159 1.799c-0.244-0.059-0.492-0.109-0.743-0.148l-0.383-2.106h-2l-0.383 2.106c-0.251 0.039-0.499 0.088-0.743 0.148l-1.159-1.799-1.848 0.765 0.452 2.092c-0.216 0.132-0.426 0.273-0.629 0.422l-1.761-1.219-1.414 1.414 1.219 1.761c-0.149 0.203-0.29 0.413-0.422 0.629l-2.092-0.452-0.765 1.848 1.799 1.159c-0.059 0.244-0.109 0.492-0.148 0.743l-2.106 0.383v2l2.106 0.383c0.039 0.251 0.088 0.499 0.148 0.743l-1.799 1.159 0.765 1.848 2.092-0.452c0.132 0.216 0.273 0.426 0.422 0.629l-1.219 1.761 1.414 1.414 1.761-1.219c0.203 0.149 0.413 0.29 0.629 0.422l-0.452 2.092 1.848 0.765 1.159-1.799c0.244 0.059 0.492 0.109 0.743 0.148l0.383 2.106h2l0.383-2.106c0.251-0.039 0.499-0.088 0.743-0.148l1.159 1.799 1.848-0.765-0.452-2.092c0.216-0.132 0.426-0.273 0.629-0.422l1.761 1.219 1.414-1.414-1.219-1.761c0.149-0.203 0.29-0.413 0.422-0.629l2.092 0.452 0.765-1.848-1.799-1.159c0.059-0.244 0.109-0.492 0.148-0.743l2.106-0.383zM21 15.35c-2.402 0-4.35-1.948-4.35-4.35s1.948-4.35 4.35-4.35 4.35 1.948 4.35 4.35c0 2.402-1.948 4.35-4.35 4.35z"></path>
                    </svg>
                </button>
            </template>
            <template v-slot:dropdown-contents>
                <a href="#" class="flex bg-purple-500 hover:bg-purple-600 text-white border rounded px-4 py-2">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"></path>
                    </svg>
                    Edit Issue
                </a>
                <a href="#" class="flex bg-green-500 hover:bg-green-600 text-white border rounded px-4 py-2">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                        <path d="M38 6H10c-2.21 0-4 1.79-4 4v28c0 2.21 1.79 4 4 4h28c2.21 0 4-1.79 4-4V10c0-2.21-1.79-4-4-4zm-4 20h-8v8h-4v-8h-8v-4h8v-8h4v8h8v4z"></path>
                    </svg>
                    Add Stamp
                </a>
            </template>
        </dropdown-menu>
        <footer class="mt-4 bg-blue-800">
            <div class="container mx-auto p-3 text-center text-white">
                Copyright &copy; 2019 Michael Perks
            </div>
        </footer>
    </div>
</body>

</html>