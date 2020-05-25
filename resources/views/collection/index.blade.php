@extends('layouts.app', ['showBrowse' => false])

@section('content')

    <collection-page
        :collection="{{ $collection }}"
        :collected-stamps="{{ $collectedStamps }}"
        :collection-values="{{ json_encode($collectionValues)}}"
        :gradings="{{ $gradings }}"
        :year="{{ $year }}"
        :stamps-count="{{ $stampsCount }}"
    >
    </collection-page>
    
@endsection