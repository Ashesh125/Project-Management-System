<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function check(Request $request)
    {
        switch (parent::checkOperaion($request['id'], $request['name'])) {
            case "store":
                return $this->store($request);
                break;

            case "destroy":
                return $this->destroy(Issue::find($request['id']));
                break;

            case "update":
                return $this->update($request, Issue::find($request['id']));
                break;

            default:
                return redirect()->back()
                    ->with('error', 'Something Went Wrong.');
        }
    }

    public function index()
    {
        $issues = Issue::all();

        return view('pages.issues.list')->with(compact('issues'));
    }


    public function ofActivity($id)
    {
        $activity = Activity::with('issues')->findOrFail($id);

        return view('pages.issues.list')->with(compact('activity'));
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
        $issue = new Issue();
        $issue->fill($request->post())->save();

        // return redirect('/issues');
        return redirect()->back()
            ->with('success', 'Issue created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        $request->validate([
            'name' => 'required',
            'activity_id' => 'required',
            'status' => 'required',
            'user_id' => 'required'
        ]);

        $issue->fill($request->post())->save();

        return redirect()->back()
            ->with('success', 'Issue Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect()->back()
            ->with('success', 'Issue Deleted Successfully');
    }
}
