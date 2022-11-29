<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\Issue;
use App\Models\User;
use App\Http\Controllers\TasksController;
use App\Models\Activity;
use Illuminate\Support\Facades\Notification;
use App\Notifications\IssueCreatedNotification;
use App\Notifications\IssueResolvedNotification;

class NotificationController extends Controller
{


    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);

        $newNotifications = $user->notifications()->whereNull('read_at')->paginate(10);
        $oldNotifications = $user->notifications()->whereNotNull('read_at')->paginate(10);

        return view('pages.notifications.index', compact('newNotifications','oldNotifications'));
    }

    public function markAsRead(Request $request)
    {
        auth()->user()->notifications->where("id", $request->id)->markAsRead();

        return redirect()->back()
            ->with('success', 'Done');
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications->where("notifiable_id", auth()->user()->id)->markAsRead();

        return redirect()->back()
            ->with('success', 'Done');
    }

    public function taskToActivity(Request $request){
        $task = Tasks::findOrFail($request->id);
        $request->id = $task->activity_id;
        $request->type = 'kanban';
        $taskController = new TasksController();

        return $taskController->usertasks($request);
    }

    public function forActivityUsers(Activity $activity){
        $activity::with('tasks.user');

        $users = array();
        $temp = array();
        foreach ($activity->tasks as $task){
            if (!in_array($task->user->id, $temp)){
                $users[] = $task->user;
                $temp[] = $task->user->id;
            }
        }

        $users[] = User::findOrFail($activity->user_id);
        return $users;
    }

    public function issueCreated(Activity $activity){
        $users = $this->forActivityUsers($activity);

        Notification::send($users, new IssueCreatedNotification($activity));
    }

    public function issueResolved(Activity $activity,Issue $issue){
        $users = $this->forActivityUsers($activity);

        Notification::send($users, new IssueResolvedNotification($issue));
    }
}
