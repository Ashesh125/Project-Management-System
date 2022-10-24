<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{


    public function check(Request $request)
    {
        switch (parent::checkOperaion($request['id'], $request['name'])) {
            case "store":
                return $this->store($request);
                break;

            case "destroy":
                return $this->destroy(Tasks::find($request['id']));
                break;

            case "update":
                return $this->update($request, Tasks::find($request['id']));
                break;

            default:
                return redirect()->route('projects')
                    ->with('error', 'Something Went Wrong.');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Tasks();
        $task->fill($request->post())->save();
        return redirect()->route('projectdetail',$request->project_id)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $tasks)
    {
        
        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasks $tasks)
    {
        $tasks->save();
        return redirect()->route('projectdetail ',$tasks->project_id)
            ->with('success', 'Data updated successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */

    public function updateType(Request $request){
        Tasks::where('id', $request->id)->update(array('type' => $request->type));
        
        return redirect()->route('mytasksK'); 
    }


    public function update(Request $request, Tasks $task)
    {
        $request->validate([
            'name' => 'required',
            'assigned_to' => 'required',
            'type' => 'required',
            'due_date' => 'required',
            'status' => 'required', 
            'description' => 'required'
        ]);
        $task->fill($request->post())->save();

        return redirect()->route('projectdetail',$request->project_id)
            ->with('success', 'Task Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $tasks)
    {
        $tasks->delete();

        return redirect()->route('projectdetail',$tasks->project_id)
            ->with('success', 'Task deleted successfully');
    }

    public function test($id){
        $project = Tasks::with('project')->where('assigned_to',$id)->where('project_id',$id)->get();
        dd($project);
        return view('pages.projects.myprojects', compact('project'));
    }


}
