{{-- {{ dd($collectedStamps) }} --}}

<table>
    <tr>
        <th>Stamp Id</th>
        <th>Stamp Title</th>
        <th>Grading</th>
        <th>Face Value</th>
        <th>Grading Value</th>
    </tr>
@foreach ($collectedStamps as $stamp_id => $stamps)
    @foreach ($stamps as $stamp)
        @foreach($stamp as $data)
            {{-- {{ dd($data) }} --}}
        <tr>
            <td>{{ $data['stamp_id'] }}</td>
            <td>{{ $data['stamp']['title'] }}</td>
            <td>{{ $data['grading']['grading'] }}</td>

            @if ($data['grading']['type'] == "mint")
                <td>{{ $data['stamp']['face_value'] }}</td>    
                <td>{{ $data['stamp']['mint_value'] }}</td>
            @endif


            @if ($data['grading']['type'] == "used")
                <td>0</td>
                <td>{{ $data['stamp']['used_value'] }}</td>
            @endif
        </tr>
        @endforeach
    @endforeach

@endforeach
</table>