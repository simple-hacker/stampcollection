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
        <thead class="">
            <tr>
                <th class="py-1 px-2 border w-32">Issue Date</th>
                <th class="py-1 px-2 border">Issue Title</th>
                <th class="py-1 px-2 border">Stanley Gibbons</th>
                <th class="py-1 px-2 border">Stamp Title</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentIssueId = 0;
                $issueCount = 0;
            @endphp
            @foreach ($missingStamps as $stamp)
                    @php
                        if ($stamp['issue']['id'] != $currentIssueId) {
                            $issueCount += 1;
                            $rowColour = ($issueCount % 2 == 0) ? 'bg-green-100' : 'bg-green-200';
                        }
                        $currentIssueId = $stamp['issue']['id'];
                    @endphp
                    <tr class="{{ $rowColour }}">
                        <td class="py-1 px-2 border w-32"><strong>{{ date("Y", strtotime($stamp['issue']['release_date'])) }}</strong> ({{ date("j M", strtotime($stamp['issue']['release_date'])) }})</td>
                        <td class="py-1 px-2 border">{{ $stamp['issue']['title'] }}</td>
                        <td class="py-1 px-2 border">{{ $stamp['sg_number'] }}</td>
                        <td class="py-1 px-2 border">{{ $stamp['title'] }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>