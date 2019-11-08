@extends('layouts.app')

@section('content')
    <h1 class="text-4xl border-b p-1 mb-3">{{ $issue->title }}</h1>
    @isset ($issue->release_date)
        <small class="mb-3">Released {{ $issue->release_date->format('j F, Y') }}</small>
    @endisset
    <p>{!! nl2br(e($issue->description)) !!}</p>
    <div class="flex flex-col">
        <h2 class="text-2xl">Stamps</h2>
        @forelse ($issue->stamps as $stamp)
            <div class="flex border p-3 justify-between">
                <div class="flex flex-col w-1/4 items-center justify-center p-1 mr-2">
                    <a href="{{ asset($stamp->image_src) }}"><img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-20"></a>
                    <p class="mb-3 text-center">{{ $stamp->title }}</p>
                    @auth
                    <form method="POST" action="{{ $stamp->addToCollectionPath() }}">
                        @csrf
                        <button type="submit" class="border rounded p-2 text-center w-full bg-blue-400 text-white">Add to collection</button>
                    </form>
                    @endauth
                </div>
                <p class="w-3/4">{!! nl2br(e($stamp->description)) !!}</p>
            </div>
        @empty  
            <p>No Stamps for this issue.</p>
        @endforelse
    </div>
@endsection