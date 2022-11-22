<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Http\Controllers\TasksController;

class NotificationController extends Controller
{


    public function index()
    {
        $newNotifications = auth()->user()->unreadNotifications;
        $oldNotifications = auth()->user()->readNotifications;

        return view('pages.notifications.index', compact('newNotifications','oldNotifications'));
    }

    public function markAsRead(Request $request)
    {
        switch ($request->type) {
            case "taskGiven":
                auth()->user()->notifications->where("id", $request->id)->markAsRead();
                break;
        }
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
}
