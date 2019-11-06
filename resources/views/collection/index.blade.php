@extends('layouts.app')

@section('content')
    @forelse ($collection as $issue)
        <div class="issue mb-5">
            <h2 class="text-3xl border-b p-1 mb-2">{{ $issue->first()->issue->title}}</h2>
            <div class="flex">
                @forelse ($issue as $stamp)
                <a href="/browse/{{ $stamp->path() }}">
                    <div class="flex flex-col items-center mr-1 p-1 border">
                        <img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-20">
                        <p>{{ $stamp->title }}</p>
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