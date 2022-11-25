<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\Activity;
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
    public function index($id)
    {
        $activity = Activity::with('tasks.user')->findOrFail($id);

        return view('pages.tasks.taskcalander', compact('activity'));
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
        return redirect()->back()
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
        return redirect()->back()
            ->with('success', 'Data updated successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */

    public function updateType(Request $request)
    {
        Tasks::where('id', $request->id)->update(array('type' => $request->type));

        return ;
    }


    public function update(Request $request, Tasks $task)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'type' => 'required',
            'due_date' => 'required',
            'status' => 'required',
            'description' => 'required',
            'activity_id' => 'required'
        ]);
        $task->fill($request->post())->save();

        $activity = Activity::findOrfail($request->activity_id);
        Activity::where('id', $activity->id)->update(array('status' => $activity->avg_task));

        return redirect()->back()
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

        return redirect()->back()
            ->with('success', 'Task deleted successfully');
    }

    public function usertasks(Request $request)
    {
        $activity = Activity::findOrFail($request->id);
        $tasks = Tasks::where([['user_id', '=', auth()->user()->id], ['activity_id', '=', $request->id]])->get();

        switch ($request->type) {
            case "table":
                return view('pages.tasks.mytasks', compact('tasks','activity'));
                break;

            case "kanban":
                return view('pages.tasks.mytaskskanban', compact('tasks','activity'));
                break;

            case "calander":
                return view('pages.tasks.taskcalander', compact('activity'));
                break;
        }
    }

    public function userTasksJson(Request $request){
        $tasks = Tasks::where([['user_id', '=', auth()->user()->id], ['activity_id', '=', $request->id]])->get();

        return  response()->json($tasks);
    }

    public function taskData($id){
        $task = Tasks::with(['activity','user'])->findOrFail($id);

        return  response()->json($task);
    }


    public function userTasksAllJson(Request $request){
        $tasks = Tasks::with('activity')->where([['user_id', '=', auth()->user()->id]])->get();

        return  response()->json($tasks);
    }
}
