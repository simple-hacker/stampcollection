@extends('layouts.app')

@section('content')
    <h1 class="text-4xl border-b mb-4">Add Stamp to {{ $issue->title }}</h1>

    @include('stamp._form', [
        'action' => route('stamp.add', ['issue' => $issue]),
        'button_text' => 'Add Stamp'
    ])
@endsection