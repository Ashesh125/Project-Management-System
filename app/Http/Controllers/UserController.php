<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function check(Request $request)
    {
        switch (parent::checkOperaion($request['id'], $request['name'])) {
            case "store":
                return $this->store($request);
                break;

            case "destroy":
                return $this->destroy(User::find($request['id']));
                break;

            case "update":
                return $this->update($request, user::find($request['id']));
                break;

            default:
                return redirect()->route('users')
                    ->with('error', 'Something Went Wrong.');
        }
    }
    public function index()
    {
        $users = User::all();

        return view('pages.users.index')->with(compact('users'));
    }

    public function getUsers()
    {
        return User::all();
    }




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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

        $user->save();

        return redirect()->route('users')
            ->with('success', 'User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = User::findOrFail(auth()->user()->id);

        return view('pages.users.profile')->with(compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        $user = new User();

        User::where('id', $request->id)->update(array('name' => $request->name, 'email' => $request->email, 'role' => $request->role));

        return redirect()->route('users')
            ->with('success', 'User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }

    public function myActivities(Request $request)
    {
        switch ($request->type) {
            case 'table':
                $user = User::with('activity.project')->findOrFail(auth()->user()->id);
                $activities = $user->activity->unique();

                return view('pages.activities.myactivities', compact('activities'));
                break;

            case 'card':
                $projects = Activity::with('project')->whereHas('tasks', function($query) {
                    return $query->where('tasks.user_id', auth()->user()->id);
                })->get()->groupBy('project.name');
                // dd($projects);
                // $tasks = Tasks::query()->with('activity')->where('user_id', auth()->id())->get()->groupBy('activity.id');
                // dd($tasks);
                // $projects = Project::with(['activities', 'activities.tasks'])
                // ->whereHas('activities.tasks', function ($query){
                //     $query->where('user_id', auth()->user()->id);
                // })->get();
                // dd($projects);

                return view('pages.activities.myactivitylist', compact('projects'));
                break;
        }
    }


    public function myIssues()
    {
        $user = User::with('issues')->findOrFail(auth()->user()->id);

        $issues = $user->issues->unique();

        return view('pages.issues.myissues', compact('issues'));
    }


    public function myTasksKanban()
    {
        $user = User::with('task')->findOrFail(auth()->user()->id);

        return view('pages.tasks.mytaskskanban', compact('user'));
    }
}
