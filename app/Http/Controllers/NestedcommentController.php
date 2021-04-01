<?php

namespace App\Http\Controllers;

use App\Models\Nestedcomment;
use App\Models\Comment;
use Illuminate\Http\Request;

class NestedCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.comments.index-nested',['comments'=>Nestedcomment::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Comment $comment)
    {
        //
        //dd($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Comment $comment)
    {

        $inputs = request()->validate(['body'=>'required']);
        $inputs['comment_id'] = $comment->id;
        $inputs['status'] = 'Unapproved';

        auth()->user()->nestedcomments()->create($inputs);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nestedcomment  $nestedcomment
     * @return \Illuminate\Http\Response
     */
    public function show(Nestedcomment $nestedcomment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nestedcomment  $nestedcomment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Nestedcomment $nestedcomment)
    {
        //
        return view('admin.comments.edit-nested',['nestedcomment'=>$nestedcomment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nestedcomment  $nestedcomment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nestedcomment $nestedcomment)
    {
        $inputs = request()->validate(['body'=>'required','status'=>'required']);
        $nestedcomment->update($inputs);
        session()->flash('updatecommentmessage','Comment was successfully updated!');
        return redirect()->route('nestedcomments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nestedcomment  $nestedcomment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nestedcomment $nestedcomment)
    {
        $nestedcomment->delete();
        session()->flash('deletecommentmessage','Comment was successfully deleted!');
        return redirect()->route('nestedcomments.index');
    }
}
