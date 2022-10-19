<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tasks;
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
        $project = Project::findOrFail($id);
        
        return view('pages.tasks.list', compact('project'));
    }


    public function index()
    {
        $projects = Project::all();

        return view('pages.projects.list')->with(compact('projects'));
    }

    public function progress(int $id)
    {
        $projectprogress = Project::with('avgTask')->where('id','=',$id)->avg('status');
        //SELECT projects.*,avg(tasks.status)*100 as avg_tasks FROM projects JOIN tasks on projects.id = tasks.project_id GROUP BY tasks.project_id;
        dd($projectprogress);
        return view('pages.tasks.list')->with(compact('projectdetail'));
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

    public function show(Project $projects)
    {
    }

    public function edit(Project $project)
    {
        $project->save();
        return redirect('/projects')
            ->with('success', 'Data updated successfully');
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
}
