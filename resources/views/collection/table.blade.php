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

    <table class="border border-collapse">
        <tr>
            <th class="py-1 px-2 border">Issue Date</th>
            <th class="py-1 px-2 border">Issue Title</th>
            <th class="py-1 px-2 border">Stanley Gibbons</th>
            <th class="py-1 px-2 border">Face Value</th>
            <th class="py-1 px-2 border">Stamp Title</th>
            <th class="py-1 px-2 border">Grading</th>
            <th class="py-1 px-2 border">Value</th>
        </tr>
    @foreach ($collectedStamps as $stamp_id => $stamps)
        @foreach ($stamps as $stamp)
            @foreach($stamp as $data)
            <tr>
                <td class="py-1 px-2 border">{{ $data['stamp']['issue']['release_date'] }}</td>
                <td class="py-1 px-2 border">{{ $data['stamp']['issue']['title'] }}</td>
                <td class="py-1 px-2 border">{{ $data['stamp']['sg_number'] }}</td>

                @if ($data['grading']['type'] == "mint")
                    <td class="py-1 px-2 border">£{{ number_format($data['stamp']['face_value'], 2) }}</td>
                @elseif ($data['grading']['type'] == "used")
                    <td class="py-1 px-2 border">£0.00</td>
                @else
                    <td class="py-1 px-2 border">£0.00</td>
                @endif

                <td class="py-1 px-2 border">{{ $data['stamp']['title'] }}</td>
                <td class="py-1 px-2 border">{{ $data['grading']['grading'] }}</td>

                @if ($data['grading']['type'] == "mint")  
                    <td class="py-1 px-2 border">£{{ number_format($data['stamp']['mint_value'], 2) }}</td>
                @elseif ($data['grading']['type'] == "used")
                    <td class="py-1 px-2 border">£{{ number_format($data['stamp']['used_value'], 2) }}</td>
                @else
                    <td class="py-1 px-2 border">£0.00</td>
                @endif
            </tr>
            @endforeach
        @endforeach

    @endforeach
    </table>
</body>
</html>