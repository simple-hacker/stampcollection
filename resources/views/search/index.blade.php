@extends('layouts.app')

@section('content')

<h1 class="text-4xl p-3 mb-3 bg-darker text-center text-white">Search results for {{ $query }}</h1>
<h2 class="text-3xl p-3 bg-dark text-center text-white">Stamps</h2>
<div class="flex flex-wrap justify-start py-3 px-2 bg-white shadow mb-5">
    @isset($results['stamps'])
        @foreach ($results['stamps'] as $stamp)
            <a href="{{ $stamp->url}}" class="w-1/5 max-w-1/5 flex flex-col items-stretch justify-center p-2 mb-2 border rounded hover:bg-light hover:border-highlight">
                <img src="{{ asset($stamp->searchable->image_src) }}" alt="{{ $stamp->title }}" class="h-20 self-center">
                <p class="text-xs text-center mt-1">{{ $stamp->title }}</p>
                @if($stamp->searchable->sg_number)
                    <p class="text-xs text-center mt-1">{{ $stamp->searchable->prefixedSgNumber }}</p>
                @endif
            </a>
        @endforeach
    @else
        <p class="w-full text-center p-4 text-xl">No stamp results for <em>{{ $query }}</em></p>
    @endisset
</div>

<h2 class="text-3xl p-3 bg-dark text-center text-white">Issues</h2>
<div class="flex flex-col items-stretch py-3 px-2 bg-white shadow mb-5">
    @isset($results['issues'])
        @foreach ($results['issues'] as $issue)
            <a href="{{ $issue->url}}" class="p-3 mb-2 border rounded hover:bg-light hover:border-highlight">
                <p class="text-center mt-1">{{ $issue->title }} ({{ $issue->searchable->year }})</p>
            </a>
        @endforeach
    @else
        <p class="w-full text-center p-4 text-xl">No issue results for <em>{{ $query }}</em></p>
    @endisset
</div>

@endsection