@extends('layouts.app')

@section('content')
<h1 class="text-4xl border-b mb-4">Add Stamp to {{ $issue->title }}</h1>



    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif





    <form method="POST" action="{{ route('add.stamp', ['issue' => $issue]) }}">
        @csrf
        <div class="flex items-center mb-6">
            <div class="w-1/3">
                <label for="title" class="text-gray-500 font-bold p-4">Title</label>
            </div>
            <div class="w-2/3">
                <input id="title" name="title" type="text" value="{{ old('title') }}" placeholder="Title" class="w-full p-2 rounded border shadow" required>
            </div>
        </div>
        <div class="flex items-center mb-6">
            <div class="w-1/3">
                <label for="price" class="text-gray-500 font-bold p-4">Price</label>
            </div>
            <div class="w-2/3">
                <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price') }}" placeholder="0.00" class="w-full p-2 rounded border shadow">
            </div>
        </div>
        <div class="flex items-center mb-6">
            <div class="w-1/3">
                <label for="description" class="text-gray-500 font-bold p-4">Description</label>
            </div>
            <div class="w-2/3">
                <textarea id="description" name="description" placeholder="Description" class="w-full p-2 rounded border shadow">{{ old('description') }}</textarea>
            </div>
        </div>
        <div class="flex items-center justify-center mb-6">
            <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">Add Stamp</button>
        </div>
    </form>
@endsection