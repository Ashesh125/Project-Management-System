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
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function check(Request $request)
    {
        switch (parent::checkOperation($request)) {
            case "store":
                return $this->store($request);
                break;

            case "destroy":
                return $this->destroy(User::find($request['id']));
                break;

            case "update":
                return $this->update($request, User::find($request['id']));
                break;

            case "restore":
                User::withTrashed()->findOrFail($request->id)->restore();

                return redirect()->route('users')
                ->with('success', 'User Restored.');
                break;

            default:
                return redirect()->route('users')
                    ->with('error', 'Something Went Wrong.');
        }
    }
    public function index()
    {
        $users = User::withTrashed()->get();

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


    public function updateProfile(Request $request)
    {

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
            ]);

            $user =  User::findOrFail(auth()->user()->id);

            if (Storage::exists('public/user/' . $user->image)) {
                Storage::delete('public/user/' . $user->image);
            }

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->image->store('user', 'public');
            User::where('id', auth()->user()->id)->update(array('image' => $request->image->hashName()));
        }

        if ($request->password) {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);
            User::where('id', auth()->user()->id)->update(array('name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)));
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required'
            ]);
            User::where('id', auth()->user()->id)->update(array('name' => $request->name, 'email' => $request->email));
        }


        return redirect()->back()
            ->with('success', 'Update Success');
    }


    public function destroy(User $user)
    {
        // if (Storage::exists('public/user/' . $user->image)) {
        //     Storage::delete('public/user/' . $user->image);
        // }

        $user->delete();

        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }

    public function myActivities(Request $request)
    {
        switch ($request->type) {
            case 'table':
                if (auth()->user()->role == 0) {
                    $user = User::with('activity.project')->findOrFail(auth()->user()->id);
                    $activities = $user->activity->unique();
                } else {
                    $activities = Activity::where('user_id', auth()->user()->id)->get();
                }

                return view('pages.activities.myactivities', compact('activities'));
                break;

            case 'card':
                if (auth()->user()->role == 0) {
                    $projects = Activity::with('project')->whereHas('tasks', function ($query) {
                        return $query->where('tasks.user_id', auth()->user()->id);
                    })->get()->groupBy('project.name');
                } else {
                    $projects = Activity::with('project')->with('tasks')->where('user_id', auth()->user()->id)->get()->groupBy('project.name');
                }

                return view('pages.activities.myactivitylist', compact('projects'));
                break;
        }
    }


    public function myIssues()
    {
        if(auth()->user()->id == 0){
            $user = User::with('activity.issues.user')->findOrFail(auth()->user()->id);
            $activities = $user->activity->unique();

            return view('pages.issues.myissues', compact('activities'));
        }else{
            $activities = Activity::with('issues.user')->where('user_id',auth()->user()->id)->get();
            // $activities = $user->activity->unique();

            return view('pages.issues.myissues', compact('activities'));

        }
    }


    public function myTasksKanban()
    {
        $user = User::with('task')->findOrFail(auth()->user()->id);

        return view('pages.tasks.mytaskskanban', compact('user'));
    }


    public function userData(Request $request)
    {
        $user = User::withTrashed()->findOrFail($request->id);

        return  response()->json($user);
    }
}
