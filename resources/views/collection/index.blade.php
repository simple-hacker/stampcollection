@extends('layouts.app')

@section('content')

    <div class="mb-8 bg-white rounded shadow">
        <h1 class="mb-2 p-4 bg-darker text-white text-4xl">My Collection</h1>
        <div class="flex flex-col items-center py-2 px-4">
            {{-- Total Value --}}
            <h3 class="text-3xl font-medium mb-3">Your collection is worth a total <strong>£{{ number_format($collectionValues['total'], 2) }}</strong></h3>
            {{-- Grading Values --}}
            <div class="flex w-full justify-center flex-wrap">
                <div data-toggle="tooltip" title="Face Value" class="ml-1 mr-1 mb-2 py-2 px-4 rounded-lg border-4 border-face text-face">
                    <div class="flex flex-col items-center font-semibold">
                        <span>£{{ number_format($collectionValues['face'], 2) }}</span>
                        <small>Face Value</small>
                    </div>
                </div>
                @foreach($collectionValues['gradings'] as $type => $grading)
                    <div data-toggle="tooltip" title="{{ $grading['description'] }}" class="ml-1 mr-1 mb-2 py-2 px-4 rounded-lg border-4 border-{{ $type }} text-{{ $type }}">
                        <div class="flex flex-col items-center font-semibold">
                            <span>£{{ number_format($grading['value'], 2) }}</span>
                            <small>{{ $grading['type'] }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @foreach ($collection as $year => $issues)
        @forelse ($issues as $issue)
            <div class="mb-4 bg-white rounded shadow">
                <a href="{{ route('catalogue.issue', ['issue' => $issue, 'slug' => $issue->slug]) }}"
                    class="flex justify-between items-center px-4 py-2 bg-dark text-white mb-1"
                >
                    {{-- Issue Title and Date --}}
                    <div class="flex flex-col">
                        <h2 class="text-2xl">{{ $issue->title}}</h2>
                        @isset ($issue->release_date)
                            <small class="mt-1">Released {{ Carbon\Carbon::parse($issue->release_date)->toFormattedDateString() }}</small>
                        @endisset
                    </div>
                    {{-- Issue Stamp Data --}}
                    <div class="flex text-xl items-center">
                        <div data-toggle="tooltip" title="{{ $issue->stamps_count }} stamps in this issue" class="flex items-center mr-5">
                            <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                                <path d="M8 4v28l10-10 10 10v-28zM24 0h-20v28l2-2v-24h18z"></path>
                            </svg>
                            <span>{{ $issue->stamps_count }}</span>
                        </div>
                        <div data-toggle="tooltip" title="{{ count($issue->stamps) }} stamps collected in this issue" class="flex items-center mr-5">
                            <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                                <path d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>
                            </svg>
                            <span>{{ count($issue->stamps) }}</span>
                        </div>
                        @php $missing = $issue->stamps_count - count($issue->stamps); @endphp
                        @if ($missing > 0)
                            <div data-toggle="tooltip" title="{{ $missing }} stamps missing from collection" class="flex items-center">
                                <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                                    <path d="M16 2.899l13.409 26.726h-26.819l13.409-26.726zM16 0c-0.69 0-1.379 0.465-1.903 1.395l-13.659 27.222c-1.046 1.86-0.156 3.383 1.978 3.383h27.166c2.134 0 3.025-1.522 1.978-3.383h0l-13.659-27.222c-0.523-0.93-1.213-1.395-1.903-1.395v0z"></path>
                                    <path d="M18 26c0 1.105-0.895 2-2 2s-2-0.895-2-2c0-1.105 0.895-2 2-2s2 0.895 2 2z"></path>
                                    <path d="M16 22c-1.105 0-2-0.895-2-2v-6c0-1.105 0.895-2 2-2s2 0.895 2 2v6c0 1.105-0.895 2-2 2z"></path>
                                </svg>
                                <span>{{ $missing }}</span>
                            </div>
                        @endif
                    </div>
                </a>
                <div class="flex flex-wrap items-start px-4 py-2">
                    @forelse ($issue->stamps as $stamp)
                        <button @click.prevent="$modal.show('collection', {stamp: {{$stamp}}})" class="flex min-w-1/6 max-w-1/5">
                            <div class="flex flex-col flex-1 items-center mr-1 p-1 border">
                                <img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-20 mb-2">
                                @isset($stamp->prefixedSgNumber)
                                    <p class="italic">{{ $stamp->prefixedSgNumber }}</p>
                                @endisset
                                @isset($stamp->sg_illustration)
                                    <p class="italic">{{ $stamp->sg_illustration }}</p>
                                @endisset
                                <p class="text-sm flex-1">{{ $stamp->title }}</p>
                                <div class="flex flex-wrap justify-center border-t p-2">
                                    @foreach ($collectedStamps[$stamp->id] as $data)
                                    <div title="{{ $data[0]['grading']['type'] }}&#10;&#13;{{ $data[0]['grading']['description'] }}"
                                        class="py-1 px-3 mx-1 mt-1 rounded-lg text-xs font-semibold text-white bg-{{ $data[0]['grading']['abbreviation'] }}"
                                    >
                                            {{ count($data) }} x {{ $data[0]['grading']['abbreviation'] }}
                                        </div>
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
            <p>You don't have any stamps in your collection for the year {{ $year }}</p>
        @endforelse
    @endforeach
@endsection