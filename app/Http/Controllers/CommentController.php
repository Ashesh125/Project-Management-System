<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function check(Request $request)
    {
        switch (parent::checkOperaion($request['id'], $request['name'])) {
            case "store":
                return $this->store($request);
                break;

            case "destroy":
                return $this->destroy(Comment::find($request['id']));
                break;

            case "update":
                return $this->update($request, Comment::find($request['id']));
                break;

            default:
                return redirect()->back()
                    ->with('error', 'Something Went Wrong.');
        }
    }

    public function index()
    {
        $comments = Comment::all();

        return view('pages.comments.list')->with(compact('comments'));
    }


    public function ofIssue($id)
    {
        $comments = Comment::with('user')->where('issue_id',$id)->get();
        $issue_id = $id;

        return view('pages.comments.list')->with(compact('comments','issue_id'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->fill($request->post())->save();
        
        // return redirect('/comments');
        return redirect()->back()
            ->with('success', 'Comment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'description' => 'required',
            'issue_id' => 'required',
            'user_id' => 'required'
        ]);

        $comment->fill($request->post())->save();
        // dd($comment);
        return redirect()->route('comments')
            ->with('success', 'Comment Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()
            ->with('success', 'Comment Deleted Successfully');
    }
}
