@extends('layouts.app')

@section('content')
    <div class="mb-8 p-4 bg-white rounded shadow">
        <h1 class="text-4xl border-b mb-4">Edit Stamp {{ $stamp->title }}</h1>

        @include('stamp._form', [
            'action' => route('stamp.update', ['stamp' => $stamp]),
            'button_text' => 'Edit Stamp'
        ])
    </div>
@endsection