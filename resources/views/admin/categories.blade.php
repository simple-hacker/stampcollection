@extends('layouts.app')

@section('content')

    <div class="flex">
        <div class="w-1/6 mr-1 bg-white rounded shadow flex flex-col items-stretch">
            @include('admin.navigation')
        </div>
    
        <div class="flex-1 ml-1 bg-white rounded shadow">
            Categories
    
        </div>
    </div>
@endsection