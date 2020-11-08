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
        <thead class="sticky">
            <tr>
                <th class="sticky top-0 bg-white py-1 px-2 border w-32">Issue Date</th>
                <th class="sticky top-0 bg-white py-1 px-2 border">Issue Title</th>
                <th class="sticky top-0 bg-white py-1 px-2 border">Stanley Gibbons</th>
                <th class="sticky top-0 bg-white py-1 px-2 border">Face Value</th>
                <th class="sticky top-0 bg-white py-1 px-2 border">Stamp Title</th>
                <th class="sticky top-0 bg-white py-1 px-2 border">Grading</th>
                <th class="sticky top-0 bg-white py-1 px-2 border">Value</th>
                <th class="sticky top-0 bg-white py-1 px-2 border">Qty</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentIssueId = 0;
                $issueCount = 0;
            @endphp
            @foreach ($collectedStamps as $stamp_id => $stamps)
                @foreach ($stamps as $stamp)
                    {{-- @foreach($stamp as $data) --}}
                    @php
                        if ($stamp[0]['stamp']['issue_id'] != $currentIssueId) {
                            $issueCount += 1;
                            $rowColour = ($issueCount % 2 == 0) ? 'bg-blue-100' : 'bg-blue-200';
                        }
                        $currentIssueId = $stamp[0]['stamp']['issue_id'];
                    @endphp
                    <tr class="{{ $rowColour }}">
                        <td class="py-1 px-2 border w-32"><strong>{{ date("Y", strtotime($stamp[0]['stamp']['issue']['release_date'])) }}</strong> ({{ date("j M", strtotime($stamp[0]['stamp']['issue']['release_date'])) }})</td>
                        <td class="py-1 px-2 border">{{ $stamp[0]['stamp']['issue']['title'] }}</td>
                        <td class="py-1 px-2 border">{{ $stamp[0]['stamp']['sg_number'] }}</td>

                        @if ($stamp[0]['grading']['type'] == "mint")
                            <td class="py-1 px-2 border">£{{ number_format($stamp[0]['stamp']['face_value'], 2) }}</td>
                        @elseif ($stamp[0]['grading']['type'] == "used")
                            <td class="py-1 px-2 border">£0.00</td>
                        @else
                            <td class="py-1 px-2 border">£0.00</td>
                        @endif

                        <td class="py-1 px-2 border">{{ $stamp[0]['stamp']['title'] }}</td>
                        <td class="py-1 px-2 border">{{ $stamp[0]['grading']['grading'] }}</td>

                        @if ($stamp[0]['grading']['type'] == "mint")  
                            <td class="py-1 px-2 border">£{{ number_format($stamp[0]['stamp']['mint_value'], 2) }}</td>
                        @elseif ($stamp[0]['grading']['type'] == "used")
                            <td class="py-1 px-2 border">£{{ number_format($stamp[0]['stamp']['used_value'], 2) }}</td>
                        @else
                            <td class="py-1 px-2 border">£0.00</td>
                        @endif

                        <td class="py-1 px-2 border">{{ count($stamp) }}</td>
                    </tr>
                    {{-- @endforeach --}}
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>