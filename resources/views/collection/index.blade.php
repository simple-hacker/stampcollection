{{-- {{dd($collection)}} --}}

    @forelse ($collection as $issue)
        <h1>{{ $issue->first()->issue->title}}</h1>
        <ul>
        @forelse ($issue as $stamp)
            <li>{{ $stamp->id }} - {{ $stamp->title}}</li>
        @empty
            <li>No Stamps collected for this issue. (Shouldn't see this)</li>
        @endforelse
        </ul>
    @empty
        Empty Collection
    @endforelse