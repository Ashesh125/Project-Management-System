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

        switch (auth()->user()->role) {
            case "0":
                $arr = array(
                    array('title' => 'Assigned Tasks', 'data' => $this->myTaskCount('assigned', 0), 'route' => route('myActivities', ['type' => 'card'])),
                    array('title' => 'Ongoing Tasks', 'data' => $this->myTaskCount('ongoing', 0), 'route' => route('myActivities', ['type' => 'card'])),
                    array('title' => 'Completed Tasks', 'data' => $this->myTaskCount('completed', 0), 'route' => route('myActivities', ['type' => 'card'])),
                    array('title' => 'Redo Tasks', 'data' => $this->myTaskCount('completed', 2), 'route' => route('myActivities', ['type' => 'card']))
                );
                break;

            case "1":
                $projects = Project::whereHas('activities', function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                })->get();

                $arr = array(
                    array('title' => 'Projects', 'data' => $projects->count(), 'route' => route('myActivities', ['type' => 'card'])),
                    array('title' => 'Review Pending', 'data' => $this->reviewTaskCount(), 'route' => route('myActivities', ['type' => 'card'])),
                    array('title' => 'My Activities', 'data' => $this->myActivityCount('<',100), 'route' => route('myActivities', ['type' => 'table'])),
                    array('title' => 'Issues', 'data' => $this->issueCount(), 'route' => route('issuesCard', ['type' => 'card']))
                );
                break;

            case "2":
                $projects = Project::all();
                $arr = array(
                    array('title' => 'Projects', 'data' => $projects->count(), 'route' => route('projects')),
                    array('title' => 'Users', 'data' => $this->userCount(), 'route' => route('users')),
                    array('title' => 'Activities', 'data' => $this->activityCount(), 'route' => route('projectCard')),
                    array('title' => 'Issues', 'data' => $this->allIssuesCount(), 'route' => route('issuesCard', ['type' => 'card']))
                );
                break;
        }

        $activities = Activity::whereHas('tasks', function ($query) {
            return $query->where('tasks.user_id', auth()->user()->id);
        })->get();

        if (auth()->user()->role != 0) {
            return view('pages.dashboard.index')->with(compact('arr', 'projects'));
        } else {

            return view('pages.dashboard.index')->with(compact('arr', 'activities'));
        }
    }

    protected function userCount()
    {
        return User::all()->count();
    }

    protected function reviewTaskCount(){
        $activities = Activity::with(['tasks' => function ($query) {
            $query->where([
                    ['tasks.status','!=' , 1],
                    ['tasks.type','completed']
                ]);
        }])->where([['user_id', auth()->user()->id], ['status','<',100]])->whereHas('tasks', function ($query) {
            return $query->where([
                    ['tasks.status','!=' , 1],
                    ['tasks.type','completed']
                ]);
        })->get();

        $count = 0;
        foreach($activities as $activity){
            $count += $activity->tasks->count();
        }
        return $count;
    }

    protected function activityCount(){
        return Activity::where('status','<',100)->get()->count();
    }

    private function issueCount(){
        $activities = Activity::with('issues')->where('user_id',auth()->user()->id)->whereHas('issues', function ($query) {
            return $query->where('issues.status', 0);
        })->get();

        $count = 0;
        foreach($activities as $activitiy){
            $count += $activitiy->issues->count();
        }

        return $count;
    }

    protected function myTaskCount($type, $status)
    {
        return Tasks::where([
            ['user_id', '=', auth()->user()->id],
            ['status', '=', $status],
            ['type', '!=', $type]
        ])->count();
    }

    protected function myActivityCount($type,$status)
    {
        return Activity::where([
            ['user_id', '=', auth()->user()->id],
            ['status', $type, $status]
        ])->count();
    }

    protected function allIssuesCount()
    {
        return Issue::all()->count();
    }

    protected function projectDetails($id)
    {
        $project = Project::with('lead')->with('activities.supervisor')->with('activities.tasks.user')->with('activities.issues')->findOrFail($id);

        return $project;
    }

    protected function chartData(Request $request)
    {
        $project = $this->projectDetails($request->id);

        $json = array();

        $temp = array(
            'name' => $project->name,
            'lead' => $project->lead->name,
            'start' => date('F j, Y', strtotime($project->start_date)),
            'end' => date('F j, Y', strtotime($project->end_date)),
            'remaining' => Carbon::parse($project->start_date)->diffInDays($project->end_date)
        );

        $json['main'] = $temp;

        $temp = array();
        foreach ($project->activities as $activity) {
            $temp[] = array(
                'id' => $activity->id,
                'name' => $activity->name,
                'supervisor' => $activity->supervisor->name,
                'status' => $activity->status,
                'no_of_tasks' => $activity->tasks->count(),
                'no_of_tasks_completed' => $activity->tasks->where('status', '=', 1)->count(),
                'no_of_users' => $activity->tasks->unique('user_id')->count(),
                'no_of_issues' => $activity->issues->count(),
                'no_of_issues_resolved' => $activity->issues->where('status', '=', 1)->count()
            );
        }

        $json['activity_details'] = $temp;

        // dd($json);
        return  response()->json($json);
    }
}
