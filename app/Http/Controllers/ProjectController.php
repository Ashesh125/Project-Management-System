<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Activity;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function check(Request $request)
    {
        switch (parent::checkOperaion($request['id'], $request['name'])) {
            case "store":
                return $this->store($request);
                break;

            case "destroy":
                return $this->destroy(Project::find($request['id']));
                break;

            case "update":
                return $this->update($request, Project::find($request['id']));
                break;

            default:
                return redirect()->route('projects')
                    ->with('error', 'Something Went Wrong.');
        }
    }

    public function tasks(int $id)
    {
        $project = Project::with('tasks.user')->findOrFail($id);
        $userController = new UserController();
        $users = $userController->getUsers();
        // dd($users);
        return view('pages.tasks.list', compact('project','users'));
    }

    public function index()
    {
        $projects = Project::with('lead')->get();

        $userController = new UserController();
        $users = $userController->getUsers();

        return view('pages.projects.list')->with(compact('projects','users'));
    }

    public function create()
    {
    }


    public function store(Request $request)
    {
        $project = new Project();
        $project->fill($request->post())->save();

        // return redirect('/projects');
        return redirect()->route('projects')
            ->with('success', 'Project created successfully.');
    }

    public function show($id)
    {
        $project = Project::with('lead')->with('activities.supervisor')->findOrFail($id);
        $userController = new UserController();
        $users = $userController->getUsers();

        return view('pages.projects.detail')->with(compact('project','users'));
    }

    public function edit(Project $project)
    {
    }


    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required'
        ]);

        $project->fill($request->post())->save();
        // dd($project);
        return redirect()->route('projects')
            ->with('success', 'Project Updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects')
            ->with('success', 'Project deleted successfully');
    }

    public function cardView(){
        $projects = Activity::with('project')->whereHas('tasks')->get()->groupBy('project.name');

        return view('pages.projects.projectcard', compact('projects'));
    }
}
