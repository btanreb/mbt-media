<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdditionalLogoRequest;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ClientLogo;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::get();
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client();
        return view('client.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request, $id = null)
    {
        if ($id) {
            $client = Client::find($id);
            if (!$client) {
                abort(404);
            }
        } else {
            $client = new Client();
        }

        $client->fill($request->post());

        $logo = null;

        if ($request->logo) {
            if ($client->logo) {
                Storage::delete('public/' . $client->logo);

                $clientLogo = ClientLogo::where('logo', $client->logo)->first();
                if ($clientLogo) {
                    $clientLogo->delete();
                }
            }
            if ($request->logo->store('public')) {
                $logo = $request->logo->hashName();
            }
        }

        if ($logo) {
            $client->logo = $logo;
        }

        $client->save();

        if ($logo) {
            $clientLogo = new ClientLogo();
            $clientLogo->client_id = $client->id;
            $clientLogo->logo = $logo;
            $clientLogo->save();
        }

        Session::flash('success_message', 'Dane zostały zapisane');

        return redirect()->route('client-index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        if (!$client) {
            abort(404);
        }
        return view('client.edit', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if (!$client) {
            abort(404);
        }

        if ($client->logo) {
            Storage::delete('public/' . $client->logo);
        }

        foreach ($client->logos as $logo) {
            Storage::delete('public/' . $logo->logo);
        }

        $client->logos->each(function ($logo) {
            $logo->delete();
        });

        $client->delete();
        return back();
    }

    public function storeAdditionalLogo(AdditionalLogoRequest $request, $id = null): RedirectResponse
    {
        if ($id) {
            $client = Client::find($id);
            if (!$client) {
                abort(404);
            }
        } else {
            $client = new Client();
        }

        $logo = null;

        if ($request->additionalLogo->store('public'))
        {
            $logo = $request->additionalLogo->hashName();

            $clientLogo = new ClientLogo();
            $clientLogo->client_id = $client->id;
            $clientLogo->logo = $logo;
            $clientLogo->save();
        }

        Session::flash('success_message', 'Dane zostały zapisane');

        return redirect()->route('client-edit', [
            'id' => $client->id
        ]);
    }

    public function destroyLogo(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'logoId' => 'required'
        ]);

        $clientLogo = ClientLogo::where('id', $validated['logoId'])->where('client_id', $id)->first();
        if (!$clientLogo) {
            abort(404);
        }

        if ($clientLogo->logo) {
            Storage::delete('public/' . $clientLogo->logo);
        }

        $clientLogo->delete();

        Session::flash('success_message', 'Logo zostało usunięte');

        return back();
    }

    public function getClientsLogos(Request $request): View
    {
        $validated = $request->validate([
            'clientIds' => 'required|array',
            'projectId' => 'string',
        ]);

        $project = null;
        if (isset($validated['projectId'])) {
            $project = Project::find($validated['projectId']);
        }

        $projectClients = Client::with('logos')->whereIn('id', $validated['clientIds'])->get();

        // dd($projectClients);

        return view('project._logos', compact('project', 'projectClients'));
    }
}
