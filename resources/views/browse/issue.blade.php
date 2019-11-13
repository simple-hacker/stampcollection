@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="text-4xl border-b p-1 mb-5 mr-2 flex-1">{{ $issue->title }}</h1>
        @isset($issue->cgbs_issue)
            @can('scrape issue')
                <a href="{{ route('scraper.issue', ['cgbs_issue' => $issue->cgbs_issue]) }}" class="bg-blue-500 text-white border rounded px-4 py-2">
                    @if ($issue->stamps->count() > 0)
                        Reimport Issue
                    @else
                        Import Issue
                    @endif
                </a>
            @endcan
        @endisset
        @can('update issue')
            <a href="{{ route('edit.issue', ['issue' => $issue]) }}" class="bg-purple-500 text-white border rounded px-4 py-2">
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 20 20">
                    <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"></path>
                </svg>
            </a>
            <form method="POST" action="{{ route('delete.issue', ['issue' => $issue]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white border rounded px-4 py-2">
                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M3,8v15c0,0.552,0.448,1,1,1h16c0.552,0,1-0.448,1-1V8H3z M9,19H7v-6h2V19z M13,19h-2v-6h2V19z M17,19h-2v-6 h2V19z"></path>
                            <path d="M23,4h-6V1c0-0.552-0.447-1-1-1H8C7.447,0,7,0.448,7,1v3H1C0.447,4,0,4.448,0,5s0.447,1,1,1 h22c0.553,0,1-0.448,1-1S23.553,4,23,4z M9,2h6v2H9V2z"></path>
                        </svg>
                </button>
            </form>
        @endcan
    </div>
    <div class="flex flex-col">
        @isset ($issue->release_date)
            <small class="mb-4">Released {{ $issue->release_date }}</small>
        @endisset
        <p class="mb-5">{!! nl2br(e($issue->description)) !!}</p>
        <div class="flex justify-between items-center">
            <h2 class="text-2xl border-b flex-1 mb-5">Stamps ({{ $issue->stamps->count() }})</h2>
            @can('create stamp')
                <a href="{{ route('create.stamp', ['issue' => $issue]) }}" class="flex bg-green-500 text-white border rounded px-4 py-2">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                        <path d="M38 6H10c-2.21 0-4 1.79-4 4v28c0 2.21 1.79 4 4 4h28c2.21 0 4-1.79 4-4V10c0-2.21-1.79-4-4-4zm-4 20h-8v8h-4v-8h-8v-4h8v-8h4v8h8v4z"></path>
                    </svg>
                    Add Stamp
                </a>
            @endcan
        </div>
        @forelse ($issue->stamps as $stamp)
            <div class="flex border p-3 justify-between">
                <div class="flex flex-col w-1/4 items-center justify-center p-1 mr-2">
                    <a href="{{ asset($stamp->image_src) }}"><img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-20"></a>
                    <p class="mb-3 text-center">{{ $stamp->title }}</p>
                    <p class="mb-3 text-center italic">{{ $stamp->sg_number }}</p>
                    @auth
                        @if (!$collection->contains($stamp))
                            <form method="POST" action="{{ $stamp->addToCollectionPath() }}">
                                @csrf
                                <button type="submit" class="border rounded p-2 text-center w-full bg-blue-400 text-white">Add to collection</button>
                            </form>
                        @else
                        <form method="POST" action="{{ $stamp->deleteFromCollectionPath() }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border rounded p-2 text-center w-full bg-red-400 text-white">Remove from collection</button>
                        </form>
                        @endif
                        @can('update stamp')
                            <div class="flex mt-3">
                                <a href="{{ route('edit.stamp', ['stamp' => $stamp]) }}" class="bg-purple-500 text-white border rounded px-4 py-2">
                                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 20 20">
                                        <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"></path>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('delete.stamp', ['stamp' => $stamp]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white border rounded px-4 py-2">
                                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path d="M3,8v15c0,0.552,0.448,1,1,1h16c0.552,0,1-0.448,1-1V8H3z M9,19H7v-6h2V19z M13,19h-2v-6h2V19z M17,19h-2v-6 h2V19z"></path>
                                                <path d="M23,4h-6V1c0-0.552-0.447-1-1-1H8C7.447,0,7,0.448,7,1v3H1C0.447,4,0,4.448,0,5s0.447,1,1,1 h22c0.553,0,1-0.448,1-1S23.553,4,23,4z M9,2h6v2H9V2z"></path>
                                            </svg>
                                    </button>
                                </form>
                            </div>
                        @endcan
                    @endauth
                </div>
                <p class="w-3/4">{!! nl2br(e($stamp->description)) !!}</p>
            </div>
        @empty  
            <p>No Stamps for this issue.</p>
        @endforelse
    </div>
@endsection