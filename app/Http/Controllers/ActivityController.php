<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function check(Request $request)
    {
        switch (parent::checkOperaion($request['id'], $request['name'])) {
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

    public function tasks(int $id)
    {
        $activity = Activity::with('tasks.user')->findOrFail($id);
        $userController = new UserController();
        $users = $userController->getUsers();
        // dd($users);
        return view('pages.tasks.list', compact('activity','users'));
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

        // return redirect('/activities');
        return view('pages.activities.')->with(compact('activities'));
    }

    public function show($id)
    {


        $activity = Activity::with('tasks.user')->findOrFail($id);
        $userController = new UserController();
        $users = $userController->getUsers();

        return view('pages.tasks.list', compact('activity','users'));
    }


    public function edit(Activity $activity)
    {
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
