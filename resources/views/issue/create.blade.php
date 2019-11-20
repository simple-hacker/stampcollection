@extends('layouts.app')

@section('content')
    <h1 class="text-4xl border-b mb-4">Add Issue</h1>

    @include('issue._form', [
        'action' => route('issue.add'),
        'button_text' => 'Add Issue'
    ])
@endsection