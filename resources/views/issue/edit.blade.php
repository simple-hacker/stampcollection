@extends('layouts.app')

@section('content')
    <div class="mb-8 p-4 bg-white rounded shadow">
        <h1 class="text-4xl border-b mb-4">Edit {{ $issue->title }}</h1>
        
        @include('issue._form', [
            'action' => route('issue.update', ['issue' => $issue]),
            'button_text' => 'Save Changes'
        ])
    </div>
@endsection