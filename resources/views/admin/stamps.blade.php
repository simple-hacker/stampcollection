@extends('layouts.app')

@section('content')

    <stamp-edit-page
        :catalogue="{{ $catalogue }}"
        :years="{{ $years }}"
        :year="{{ $year }}"
    >
    </stamp-edit-page>

@endsection