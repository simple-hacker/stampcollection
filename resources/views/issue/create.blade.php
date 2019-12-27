@extends('layouts.app', ['showBrowse' => true])

@section('content')
    <div class="mb-8 p-4 bg-white rounded shadow">
        <h1 class="text-4xl border-b mb-4">Create Issue for {{ $year }}</h1>

        @include('issue._form', [
            'action' => route('issue.add'),
            'button_text' => 'Create Issue'
        ])
    </div>
@endsection