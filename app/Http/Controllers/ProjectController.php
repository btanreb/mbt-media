<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('clients')->get();
        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = new Project();
        $clients = Client::get();

        $clientsJs = [];
        foreach ($clients as $client) {
            $clientsJs[] = ['id' => $client->id, 'name' => $client->name];
        }

        $projectClients = [];
        $selectedClientsJs = [];

        return view('project.create', compact('project', 'clients', 'projectClients', 'clientsJs', 'selectedClientsJs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request, $id = null)
    {
        if ($id) {
            $project = Project::find($id);
            if (!$project) {
                abort(404);
            }
        } else {
            $project = new Project();
        }

        $project->fill($request->post());
        $project->save();

        if ($request->clientIds && $request->clientIds[0] != null) {
            $project->clients()->sync(array_unique($request->clientIds));
        }

        Session::flash('success_message', 'Dane zostały zapisane');

        return redirect()->route('project-index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with(['clients', 'clients.logos'])->find($id);
        if (!$project) {
            abort(404);
        }
        $clients = Client::get();

        $clientsJs = [];
        $selectedClientsJs = [];

        // zwracam wszystkich klientów na potrzeby tworzenia <select></select> w HTML
        foreach ($clients as $client) {
            $clientsJs[] = ['id' => $client->id, 'name' => $client->name];
        }

        // zwracam wybranych klientów na potrzeby przeładowania sekcji Loga
        foreach ($project->clients as $client) {
            $selectedClientsJs[] = $client->id;
        }

        $projectClients = $project->clients;

        return view('project.edit', compact('project', 'clients', 'projectClients', 'clientsJs', 'selectedClientsJs'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            abort(404);
        }
        $project->delete();
        return back();
    }

    public function show($id): View
    {
        $project = Project::find($id);
        if (!$project) {
            abort(404);
        }
        return view('project.show', compact('project'));
    }
}
