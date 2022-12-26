<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\User;
use App\Models\Activity;
use App\Notifications\TaskGiven as NotificationsTaskGiven;
use App\Notifications\TaskGivenNotification;
use App\Notifications\TaskReviewedNotification;
use App\Notifications\TaskCompletedNotification;
use App\Notifications\ActivityCompletedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Task\Notifications\TaskGiven;
use Illuminate\Support\Arr;

class TasksController extends Controller
{


    public function check(Request $request)
    {
        switch (parent::checkOperation($request)) {
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
        $request->merge(['status' => "0"]);
        $task = new Tasks();
        $task->fill($request->post())->save();

        Notification::send(User::findOrFail($request->user_id), new TaskGivenNotification($task));
        $this->updateActivityCompletion($request->activity_id);

        return redirect()->back()
            ->with('success', 'Task Created');
    }



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
            ->with('success', 'Data Updated');
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

        if($request->type == 'completed'){
            $task = Tasks::with('activity.supervisor')->findOrFail($request->id);
            Notification::send($task->activity->supervisor, new TaskCompletedNotification($task));
        }

        return ;
    }


    public function update(Request $request, Tasks $task)
    {


        if($request->status != null){
            Notification::send(User::findOrFail($request->user_id), new TaskReviewedNotification($task));
        }else{
            $request->merge(['status' => "0"]);
        }
        $task->fill($request->post())->save();


        $this->updateActivityCompletion($request->activity_id);


        return redirect()->back()
            ->with('success', 'Task Updated');
    }


    protected function updateActivityCompletion($id){
        $activity = Activity::findOrfail($id);

        $activity_completion = $activity->avg_task;
        Activity::where('id', $activity->id)->update(array('status' => $activity_completion));
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
        $this->updateActivityCompletion($tasks->activity_id);
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

    public function taskData($id){
        $task = Tasks::with(['activity','user'])->findOrFail($id);

        return  response()->json($task);
    }


    public function userTasksAllJson(Request $request){
        $tasks = Tasks::with('activity')->where([['user_id', '=', auth()->user()->id]])->get();

        return  response()->json($tasks);
    }

    public function userTasksJson(Request $request)
    {
        $activity = Activity::findOrFail($request->id);
        $json = Tasks::where([['user_id', '=', auth()->user()->id], ['activity_id', '=', $activity->id]])->get();

        return  response()->json($json);

    }

}
