@extends('layouts.app')

@section('content')
    <h1 class="text-4xl border-b mb-4">Edit Stamp {{ $stamp->title }}</h1>

    @include('stamp._form', [
        'action' => route('update.stamp', ['stamp' => $stamp]),
        'button_text' => 'Edit Stamp'
    ])
@endsection