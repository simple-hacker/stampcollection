@extends('layouts.app')

@section('content')

    <div class="mb-8 p-4 bg-white rounded shadow">
        <h1 class="text-4xl border-b mb-6">My Collection</h1>
        <p>Your collection is worth £{{ number_format($collectionValue, 2) }}</p>
    </div>

    @forelse ($collection as $issue)
        <div class="mb-4 bg-white rounded shadow">
            <a href="{{ route('catalogue.issue', ['issue' => $issue, 'slug' => $issue->slug]) }}">
                <h2 class="text-2xl px-4 py-2 bg-blue-800 text-white mb-2">{{ $issue->title}}</h2>
            </a>
            <div class="flex flex-wrap px-4 py-2">
                @forelse ($issue->stamps as $stamp)
                    <button @click.prevent="$modal.show('collection', {stamp: {{$stamp}}})">
                        <div class="flex flex-col items-center mr-1 p-1 border w-1/8">
                            <img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-30">
                            <p>{{ $stamp->title }}</p>
                            @isset($stamp->prefixedSgNumber)
                                <p class="italic">{{ $stamp->prefixedSgNumber }}</p>
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
                    </button>
                @empty
                    <p class="text-muted">No Stamps collected for this issue.</p>
                @endforelse
            </div>
        </div>
    @empty
        <p>You don't have any stamps in your collection.</p>
    @endforelse
@endsection