@extends('layouts.app')

@section('content')

    <div class="flex items-start">
        <div class="w-1/6 mr-1 bg-white rounded shadow flex flex-col p-2">
            @include('admin.navigation')
        </div>
    
        <div class="flex flex-col flex-1 ml-1 bg-white rounded shadow p-4">
            <h1 class="text-4xl w-full border-b mb-2">Admin Area</h1>
            <div class="flex justify-between">
                <div class="flex flex-col justify-start w-1/4 mx-1 border border-darker rounded bg-light items-center p-8">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 32">
                        <path d="M24 24.082v-1.649c2.203-1.241 4-4.337 4-7.432 0-4.971 0-9-6-9s-6 4.029-6 9c0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h28c0-4.030-5.216-7.364-12-7.918z"></path>
                        <path d="M10.225 24.854c1.728-1.13 3.877-1.989 6.243-2.513-0.47-0.556-0.897-1.176-1.265-1.844-0.95-1.726-1.453-3.627-1.453-5.497 0-2.689 0-5.228 0.956-7.305 0.928-2.016 2.598-3.265 4.976-3.734-0.529-2.39-1.936-3.961-5.682-3.961-6 0-6 4.029-6 9 0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h8.719c0.454-0.403 0.956-0.787 1.506-1.146z"></path>
                    </svg>
                    <p class="mt-3 text-2xl font-bold">{{ $usersCount }} Users</p>
                </div>
                <div class="flex flex-col justify-start w-1/4 mx-1 border border-darker rounded bg-light items-center p-8">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 32">
                        <path d="M28.681 11.159c-0.694-0.947-1.662-2.053-2.724-3.116s-2.169-2.030-3.116-2.724c-1.612-1.182-2.393-1.319-2.841-1.319h-11.5c-1.379 0-2.5 1.122-2.5 2.5v23c0 1.378 1.121 2.5 2.5 2.5h19c1.378 0 2.5-1.122 2.5-2.5v-15.5c0-0.448-0.137-1.23-1.319-2.841zM24.543 9.457c0.959 0.959 1.712 1.825 2.268 2.543h-4.811v-4.811c0.718 0.556 1.584 1.309 2.543 2.268v0zM28 29.5c0 0.271-0.229 0.5-0.5 0.5h-19c-0.271 0-0.5-0.229-0.5-0.5v-23c0-0.271 0.229-0.5 0.5-0.5 0 0 11.499-0 11.5 0v7c0 0.552 0.448 1 1 1h7v15.5z"></path>
                        <path d="M18.841 1.319c-1.612-1.182-2.393-1.319-2.841-1.319h-11.5c-1.378 0-2.5 1.121-2.5 2.5v23c0 1.207 0.86 2.217 2 2.45v-25.45c0-0.271 0.229-0.5 0.5-0.5h15.215c-0.301-0.248-0.595-0.477-0.873-0.681z"></path>
                    </svg>
                    <p class="mt-3 text-2xl font-bold">{{ $issuesCount }} Issues</p>
                </div>
                <div class="flex flex-col justify-start w-1/4 mx-1 border border-darker rounded bg-light items-center p-8">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 32">
                        <path d="M32 10l-16-8-16 8 16 8 16-8zM16 4.655l10.689 5.345-10.689 5.345-10.689-5.345 10.689-5.345zM28.795 14.398l3.205 1.602-16 8-16-8 3.205-1.602 12.795 6.398zM28.795 20.398l3.205 1.602-16 8-16-8 3.205-1.602 12.795 6.398z"></path>
                    </svg>
                    <p class="mt-3 text-2xl font-bold">{{ $stampsCount }} Stamps</p>
                </div>
                <div class="flex flex-col justify-start w-1/4 mx-1 border border-darker rounded bg-light items-center p-8">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 32">
                        <path d="M26 30l6-16h-26l-6 16zM4 12l-4 18v-26h9l4 4h13v4z"></path>
                    </svg>
                    <p class="mt-3 text-2xl font-bold">{{ $collectionsCount }} Collection</p>
                </div>
            </div>
        </div>
    </div>
@endsection