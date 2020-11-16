@extends('layouts.app')

@section('content')

    <catalogue-page
        :catalogue="{{ $catalogue }}"
        :years="{{ $years }}"
        :year="{{ $year }}"
        :admin="{{ $admin ? 'true' : 'false' }}"
    >
    </catalogue-page>
    
@endsection