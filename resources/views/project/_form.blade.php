<div class="col-12 m-b-sm">
    <label>Nazwa projektu*</label>
    <input type="text" class="form-control" name="name" value="{{ old('name', $project->name) }}">
</div>
<div class="col-12 m-b-sm">
    <div id="selects">
        <label>Klient</label>
        @if ($project->clients->isEmpty())
            <div class="select-wrapper">
                <select type="text" class="form-control" name="clientIds[]">
                    <option value=""></option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-default destroy-select" disabled><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
            </div>
        @else
            @foreach ($project->clients as $projectClient)
                <div class="select-wrapper">
                    <select type="text" class="form-control" name="clientIds[]">
                        <option value=""></option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ $projectClient->id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-default destroy-select" {{ count($project->clients) == 1 ? 'disabled' : null }}><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                </div>
            @endforeach
        @endif
    </div>
    <button type="button" class="btn btn-default btn-xs m-t-xs" id="multi-add"><i class="fa fa-plus text-info" aria-hidden="true"></i> Dodaj kolejny</button>
</div>
<div class="col-12 m-b-sm">
    <label>Termin</label>
    <input type="date" class="form-control" name="deadline" value="{{ old('deadline', $project->deadline) }}">
</div>
<div class="col-12 m-b-sm">
    <label>Opis projektu</label>
    <textarea class="form-control" name="description">{{ old('description', $project->description) }}</textarea>
</div>

<div class="col">
    <div class="ibox-title">
        <h5>Wybierz logo</h5>
    </div>
    <div class="ibox-content">
        <input type="hidden" name="client_logo_id" value="">
        <div id="project-logos">
            @include('project._logos')
        </div>
    </div>
</div>

@push('additional-js')
    <script>
        const csrfToken = '{{ csrf_token() }}';
        const projectId = {{ isset($project->id) ? $project->id : 'null' }};
        const clients = {{ Js::from($clientsJs) }};
        let selectedClientsJs = {{ Js::from($selectedClientsJs) }};
    </script>

    @vite(['resources/js/project.js'])
@endpush
