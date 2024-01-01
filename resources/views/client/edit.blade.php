@extends('layouts.mbt')
@section('content')
    <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Edytuj klienta</h5>
            </div>
            <form class="ibox-content" method="post" action="{{ route('client-update', $client->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row form-row m-b">
                    @include('client._form')
                    <div class="col-12 m-b-sm">
                        @if ($client->logo)
                            <label>Aktualne logo</label>
                            <div>
                                <img style="max-height: 100px;" src="{{ Storage::url($client->logo) }}">
                            </div>
                        @endif
                        <label class="m-t">Zmień logo</label>
                        <input type="file" class="form-control" name="logo">
                    </div>
                </div>
                <a href="{{ route('client-index') }}" class="btn btn-default">Powrót</a>
                <button type="submit" class="btn btn-primary">Zapisz</a>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Loga dodatkowe</h5>
                    <button class="btn btn-xs text-light add-new-logo" data-toggle="modal" data-target="#addLogo">Dodaj logo dodatkowe</button>
                </div>
            </div>
            <div class="bg-white p-3">
                @foreach ($client->logos as $clientLogo)
                    @if ($client->logo === $clientLogo->logo)
                        @continue
                    @endif
                    <div class="logo-additional d-flex align-items-center">
                        <form method="POST" action="{{ route('client-destroy-logo', $client->id) }}" class="destroy-logo mb-0" id="destroy-logo-{{ $clientLogo->id }}">
                            @csrf
                            <input type="hidden" name="logoId" value="{{ $clientLogo->id }}">

                            <button type="submit" class="btn btn-danger btn-xs m-r tooltip-more" title="" data-original-title="Usuń" data-logo-id="{{ $clientLogo->id }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </form>
                        <img src="{{ Storage::url($clientLogo->logo) }}" class="logo-thumbnail">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

<div class="modal inmodal" id="addLogo" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">

            <form method="POST" action="{{ route('client-store-additional-logo', $client->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Dodaj logo dodatkowe</h4>
                </div>
                <div class="modal-body">
                    <label for="">Logo dodatkowe</label>
                    <div class="custom-file m-b-sm">
                        <input type="file" name="additionalLogo" class="">
                        <div>
                            <small>Dozwolone formaty plików: .jpg, .png, .jpeg, .svg</small> <br>
                            <small class="text-danger">Logo dodatkowe musi być plikiem typu jpg, jpeg, png, svg.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    .btn.add-new-logo { background: #d2798d; }

    .logo-additional:not(:last-child) { border-bottom: 1px solid rgba(0, 0, 0, 0.1); padding-bottom: 20px; margin-bottom: 20px }
    .logo-thumbnail { max-height: 50px; }
</style>

@push('additional-js')
    @vite(['resources/js/client.js'])
@endpush
