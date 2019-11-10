@extends('layouts.app')

@section('content')
    <h1 class="text-4xl border-b mb-6">My Collection</h1>
    @forelse ($collection as $issue)
        <div class="issue mb-5">
            <h2 class="text-xl border-b p-1 mb-2">{{ $issue->title}}</h2>
            <div class="flex flex-wrap">
                @forelse ($issue->stamps as $stamp)
                    <div class="flex flex-col items-center mr-1 p-1 border w-1/8">
                        <img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-20">
                        <p>{{ $stamp->title }}</p>
                    </div>
                @empty
                    <p class="text-muted">No Stamps collected for this issue.</p>
                @endforelse
            </div>
        </div>
    @empty
        <p>You don't have any stamps in your collection.</p>
    @endforelse
@endsection