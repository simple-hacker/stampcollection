@extends('layouts.app', ['showBrowse' => true])

@section('content')
    <div class="mb-8 p-4 bg-white rounded shadow">
        <h1 class="text-4xl border-b mb-3">{{ $stamp->title }}</h1>
        <div class="flex">
            <div class="w-1/3 mr-1">
                <img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-40">
            </div>
            <div class="w-2/3 ml-1">
                <div class="mb-3">
                    Part of <a href="{{ route('catalogue.issue', ['issue' => $stamp->issue, 'slug' => $stamp->issue->slug]) }}" class="hover:underline">{{ $stamp->issue->title }}</a>
                </div>
                @isset($stamp->prefixedSgNumber)
                    <p class="mb-2">{{ $stamp->prefixedSgNumber }}</p>
                @endisset
                @isset($stamp->description)
                    <p>{{ $stamp->description }}</p>
                @endisset
            </div>
        </div>
    </div>
    <div class="mb-8 p-4 bg-white rounded shadow">
        <h2 class="text-3xl border-b mb-4">Add To Collection</h2>
            <form method="POST" action="{{ route('collection.add', ['stamp' => $stamp]) }}">
            @csrf
            <div class="flex">
                <select name="grading_id" class="p-2 border rounded flex-1" required>
                    @foreach ($gradings as $gradingId => $gradingType)
                        <option value="{{ $gradingId }}">{{ $gradingType }}</option>
                    @endforeach
                </select>
                <input type="number" name="value" class="p-2 border rounded ml-2" step="0.01" min="0" placeholder="Value" required>
                <input type="number" name="quantity" class="p-2 border rounded ml-2" step="1" min="1" placeholder="Quantity" value="1" required>
            </div>
            <button type="submit" class="mt-5 border rounded p-2 text-center bg-blue-500 hover:bg-blue-600 text-white">Add To Collection</button>
        </form>
    </div>

    @if ($stampsInCollection->isNotEmpty())
        <div class="mb-8 p-4 bg-white rounded shadow">
            <h2 class="text-3xl border-b mb-4">Manage Collection</h2>
            @foreach ($stampsInCollection as $stampInCollection)
                <div class="flex items-center">
                    <div class="flex flex-1 justify-between">
                        <p>{{ $stampInCollection->grading->type }}</p>
                        <p>£{{ number_format($stampInCollection->value, 2) }}</p>
                    </div>
                    <div class="flex justify-end ml-4">
                        <form method="POST" action="{{ route('collection.delete', ['collection' => $stampInCollection]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border rounded p-2 text-center w-full bg-red-500 hover:bg-red-600 text-white">
                                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M3,8v15c0,0.552,0.448,1,1,1h16c0.552,0,1-0.448,1-1V8H3z M9,19H7v-6h2V19z M13,19h-2v-6h2V19z M17,19h-2v-6 h2V19z"></path>
                                    <path d="M23,4h-6V1c0-0.552-0.447-1-1-1H8C7.447,0,7,0.448,7,1v3H1C0.447,4,0,4.448,0,5s0.447,1,1,1 h22c0.553,0,1-0.448,1-1S23.553,4,23,4z M9,2h6v2H9V2z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection