@extends('layouts.app')

@section('content')

    <h1 class="text-4xl border-b mb-6">My Collection</h1>
    <p>Your collection is worth £{{ number_format($collectionValue, 2) }}</p>

    @forelse ($collection as $issue)
        <div class="issue mb-5">
            <h2 class="text-2xl border-b p-1 mb-2">{{ $issue->title}}</h2>
            <div class="flex flex-wrap">
                @forelse ($issue->stamps as $stamp)
                    <a href="{{ route('collection.show', ['stamp' => $stamp, 'slug' => $stamp->slug]) }}">
                        <div class="flex flex-col items-center mr-1 p-1 border w-1/8">
                            <img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-30">
                            <p>{{ $stamp->title }}</p>
                            @isset($stamp->sg_number)
                                <p class="italic">{{ $stamp->sg_number }}</p>
                            @endisset
                            @isset($stamp->sg_illustration)
                                <p class="italic">{{ $stamp->sg_illustration }}</p>
                            @endisset
                            <div class="mt-2 border-t">
                                @foreach ($collectionData[$stamp->id] as $data)
                                    <p>{{ count($data) }} x {{ $data[0]['grading']['abbreviation'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-muted">No Stamps collected for this issue.</p>
                @endforelse
            </div>
        </div>
    @empty
        <p>You don't have any stamps in your collection.</p>
    @endforelse
@endsection