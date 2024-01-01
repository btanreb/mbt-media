@extends('layouts.mbt')
@push('additional-css')
    @vite(['resources/css/comments.css'])
@endpush
@section('content')
    <div class="col-12">
        <div class="ibox">
            <div class="ibox-content">
                <h2>{{ $project->name }}</h2>
                <p>
                    <b>Klienci:</b>
                    @foreach ($project->clients as $key => $client)
                        {{ $client->name }}{{ count($project->clients) != ++$key ? ',' : null }}
                    @endforeach
                </p>
                <p>
                    <b>Termin:</b>
                    <br>
                    {{ $project->deadline }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="ibox-title">
            Komentarze
        </div>
        <div class="ibox-content" style="padding-top: 10px;">
            <div id="app">
                <comment-component project-id="{{ $project->id }}" />
            </div>
        </div>
    </div>
@endsection
