
@foreach ($projectClients as $client)
    @foreach ($client->logos as $clientLogo)
        <div class="project-logo">
            <input type="radio" name="client_logo_id" id="logo-{{ $clientLogo->id }}" value="{{ $clientLogo->id }}" {{ isset($project) && $project->client_logo_id == $clientLogo->id ? 'checked' : null }}>
            <label for="logo-{{ $clientLogo->id }}">
                <img src="{{ Storage::url($clientLogo->logo) }}">
            </label>
        </div>
    @endforeach
@endforeach
