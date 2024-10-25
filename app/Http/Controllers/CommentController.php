<?php

namespace App\Http\Controllers;

use App\Models\comments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment=comments::all();
        return response()->json($comment);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
        'comment'=>'required',
        ]);
        if($validator->fails()){
            $response=array(['response'=>$validator->messages(),'success'=>false]);
            return $response;
        }
        else{

            $comment=new comments;
            $comment->comment= $request->comment;
            $comment->post_id=$request->post_id;
            $comment->user_id=Auth::user()->id;
            $comment->save();
            return response()->json($comment);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment=comments::find($id);
        return response()->json($comment);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),
        [
        'comment'=>'required'
        ]);

        if($validator->fails()){
            $response=array(['response'=>$validator->messages(),'success'=>false]);
            return $response;
        }
        else{

            $comment=comments::find($id);
            $comment->content= $request->content;
            $comment->title=$request->title;
            $comment->image=$request->image;
            $comment->save();
            return response()->json($comment);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment=comments::find($id);
        if ($comment){
            $comment->delete();
            $response=array(['response'=>'the post deleted','success'=>true]);
            return $response;

        }
        else{
            $response=array(['response'=>'the post not found','success'=>false]);
            return $response;
        }
    }
}
