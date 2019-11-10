@extends('layouts.app')

@section('content')
    <div class="flex flex-col">
        <div class="flex justify-between items-center">
            <h1 class="text-4xl border-b p-1 mb-5 mr-2 flex-1">Stamps for {{ $year }}</h1>
            @can('scrape year')
                <a href="{{ route('scraper.year', ['year' => $year]) }}" class="bg-blue-500 text-white border rounded px-4 py-2">Import Issues</a>
            @endcan
            @can('create issue')
                <a href="" class="bg-green-500 text-white border rounded px-4 py-2">Add Issue</a>
            @endcan
        </div>
        
        @forelse ($issues as $issue)
            <div class="flex flex-col mb-8">
                <a href="{{ $issue->path() }}"><h2 class="text-2xl border-b mb-2">{{ $issue->title }}</h2></a>
                @isset ($issue->release_date)
                    <small class="mb-3">Released {{ $issue->release_date->format('j F, Y') }}</small>
                @endisset
                <div class="flex">
                    @forelse ($issue->stamps as $stamp)
                        <div class="flex flex-col items-center justify-center mr-1 p-1 border">
                        @if ($loop->index < 5)
                            <img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-20">
                            <p>{{ $stamp->title }}</p>
                        @elseif ($loop->index === 5)
                            <p class="p-4 text-4xl">+{{($loop->remaining + 1)}}</p>
                            </div>
                            @break
                        @endif
                        </div>
                    @empty
                        <div class="flex flex-1 justify-between">
                            <p>No Stamps for this issue.</p>
                            @can('scrape issue')
                                <a href="{{ route('scraper.issue', ['cgbs_issue' => $issue->cgbs_issue]) }}" class="bg-blue-400 text-white border rounded px-4 py-2">Import Issue</a>
                            @endcan
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <p>No Issues found.</p>
        @endforelse
    </div>
@endsection