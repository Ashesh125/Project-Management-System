<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Activity;
use App\Models\User;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function tasks(int $id)
    {
        $project = Project::with('tasks.user')->findOrFail($id);
        $users = User::where('role','>',0)->get();
        // dd($users);
        return view('pages.tasks.list', compact('project','users'));
    }

    public function index()
    {
        $projects = Project::with('lead')->get();
        $users = User::where('role','>',0)->get();

        return view('pages.projects.list')->with(compact('projects','users'));
    }

    public function create()
    {
    }


    public function store(StoreProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $project = Project::create($request->validated());
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('errors')
            ->with('error', 'Something Went Wrong !!!');
        }
        DB::commit();

        return redirect()->back()
            ->with('success', 'Project created successfully.');
    }

//bensantoenum

    public function show($id)
    {
        $project = Project::with('lead')->with('activities.supervisor')->findOrFail($id);
        $users = User::where('role','=',1)->get();

        return view('pages.projects.detail')->with(compact('project','users'));
    }

    public function edit(Project $project)
    {
    }


    public function update(UpdateProjectRequest $request, Project $project)
    {
        DB::beginTransaction();
        try {
            $project->update($request->validated());
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('errors')
            ->with('error', 'Something Went Wrong !!!');
        }
        DB::commit();

        return redirect()->route('projects')
            ->with('success', 'Project Updated');
    }

    public function destroy(Project $project)
    {
        DB::beginTransaction();
        try {
            $project->delete();
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('errors')
            ->with('error', 'Something Went Wrong !!!');
        }
        DB::commit();

        return redirect()->route('projects')
            ->with('success', 'Project deleted successfully');
    }

    public function cardView(){
        $projects = Activity::with('project')->whereHas('tasks')->get()->groupBy('project.name');
        $users = User::where('role','=',2)->get();

        return view('pages.projects.projectcard', compact('projects','users'));
    }
}
