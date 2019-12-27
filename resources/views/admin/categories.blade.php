@extends('layouts.app')

@section('content')

    <div class="flex items-start">
        <div class="w-1/6 mr-1 bg-white rounded shadow flex flex-col p-2">
            @include('admin.navigation')
        </div>
    
        <div class="flex-1 ml-1 bg-white rounded shadow p-4">
            <issue-categories
                :categories-prop="{{ $categories }}"
            ></issue-categories>
    
        </div>
    </div>
@endsection