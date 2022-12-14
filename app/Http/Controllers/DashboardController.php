<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tasks;
use App\Models\User;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{

    public function index()
    {
        $arr = array();
        if(auth()->user()->role == 2){
            $projects = Project::all();
        }else{
            $projects = Project::whereHas('activities', function ($query) {
                return $query->where('user_id', auth()->user()->id);
            })->get();
            // dd($projects);
        }

        switch(auth()->user()->role){
            case "0":
                $arr = array(
                    'all_projects' => $projects->count(),
                    'all_users' => $this->userCount(),
                    'all_myTasks' => $this->myTaskCount(),
                    'all_issues' => $this->issueCount(),
                );
                break;

            case "1":
                $arr = array(
                    'all_projects' => $projects->count(),
                    'all_users' => $this->userCount(),
                    'all_myTasks' => $this->myTaskCount(),
                    'all_issues' => $this->issueCount(),
                );
                break;

            case "2":
                $arr = array(
                    'all_projects' => $projects->count(),
                    'all_users' => $this->userCount(),
                    'all_myTasks' => $this->myTaskCount(),
                    'all_issues' => $this->issueCount(),
                );
                break;
        }

        $activities = Activity::whereHas('tasks', function ($query) {
            return $query->where('tasks.user_id', auth()->user()->id);
        })->get();

        if(auth()->user()->role != 0){
            return view('pages.dashboard.index')->with(compact('arr','projects'));
        }else{

            return view('pages.dashboard.index')->with(compact('arr','activities'));
        }
    }

    public function userCount()
    {
        return User::all()->count();
    }

    public function myTaskCount()
    {
        return Tasks::where([
            ['user_id', '=', auth()->user()->id],
            ['status', '=', 1],
            ['type', '=', 'completed']
        ])->count();
    }

    public function issueCount()
    {
        return Issue::all()->count();
    }

    public function projectDetails($id){
       $project = Project::with('lead')->with('activities.supervisor')->with('activities.tasks.user')->with('activities.issues')->findOrFail($id);

       return $project;
    }

    public function chartData(Request $request){
        $project = $this->projectDetails($request->id);

        $json = array();

        $temp = array(
            'name' => $project->name,
            'lead' => $project->lead->name,
            'start' => date('F j, Y', strtotime($project->start_date)),
            'end' => date('F j, Y', strtotime($project->end_date)),
            'remaining' => Carbon::parse( $project->start_date )->diffInDays( $project->end_date)
        );

        $json['main'] = $temp;

        $temp = array();
        foreach($project->activities as $activity){
            $temp[] = array(
                    'id' => $activity->id,
                    'name' => $activity->name,
                    'supervisor' => $activity->supervisor->name,
                    'status' => $activity->status,
                    'no_of_tasks' => $activity->tasks->count(),
                    'no_of_tasks_completed' => $activity->tasks->where('status','=',1)->count(),
                    'no_of_users' => $activity->tasks->unique('user_id')->count(),
                    'no_of_issues' => $activity->issues->count(),
                    'no_of_issues_resolved' => $activity->issues->where('status','=',1)->count()
            );
        }

        $json['activity_details'] = $temp;

        // dd($json);
        return  response()->json($json);
    }
}
