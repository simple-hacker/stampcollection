@extends('layouts.app', ['showBrowse' => true])

@section('content')
    <div class="mb-8 p-4 bg-white rounded shadow">
        <h1 class="text-4xl border-b mb-4">Add Issue</h1>

        @include('issue._form', [
            'action' => route('issue.add'),
            'button_text' => 'Add Issue'
        ])
    </div>
@endsection