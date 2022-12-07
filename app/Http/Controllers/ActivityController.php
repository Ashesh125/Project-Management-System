<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use App\Models\Tasks;
use App\Notifications\ActivityCreatedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function check(Request $request)
    {
        switch (parent::checkOperation($request)) {
            case "store":
                return $this->store($request);
                break;

            case "destroy":
                return $this->destroy(Activity::find($request['id']));
                break;

            case "update":
                return $this->update($request, Activity::find($request['id']));
                break;

            default:
                return redirect()->route('activities')
                    ->with('error', 'Something Went Wrong.');
        }
    }

    public function index()
    {
        $activities = Activity::all();

        return view('pages.activities.list')->with(compact('activities'));
    }

    public function detail($id){
        $detail = Activity::with('tasklist')->with('user')->findOrFail($id);
        dd($detail);
    }

    public function create()
    {
    }

    public function globalStatusUpdater(){
        $activities = Activity::all();

        foreach($activities as $activity){
            Activity::where('id', $activity->id)->update(array('status' => $activity->avg_task));
        }
        die("OK");
    }

    public function store(Request $request)
    {
        $activity = new Activity();
        $activity->fill($request->post())->save();

        Notification::send(User::findOrFail($request->user_id), new ActivityCreatedNotification($activity));

        return redirect()->back()
            ->with('success', 'Activity Created');
    }

    public function show($id)
    {
        $activity = Activity::with('tasks.user')->findOrFail($id);
        $users = User::where('role',0)->get();

        return view('pages.tasks.list', compact('activity','users'));
    }


    public function edit(Activity $activity)
    {
    }

    public function activityData($id){
       $activity = Activity::with('tasks.user')->findOrFail($id)->toArray();

       return  response()->json($activity);
    }

    public function baseDetail($id){
        $activity = Activity::findOrFail($id);

        return view('pages.activities.calander', compact('activity'));
    }

    public function activityDataOfUser($id){
        $activity = Tasks::where(['user_id' => auth()->user()->id, 'activity_id' => $id])->get()->toArray();

        return  response()->json($activity);
     }



    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required'
        ]);

        $activity->fill($request->post())->save();
        // dd($activity);
        return redirect()->back()
            ->with('success', 'Activity Updated');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->back()
            ->with('success', 'Activity deleted successfully');
    }
}
