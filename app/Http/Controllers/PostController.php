<?php

namespace App\Http\Controllers;

use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class postController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post=posts::all();
        return response()->json($post);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
        'content'=>'required',

        ]);
        if($validator->fails()){
            $response=array(['response'=>$validator->messages(),'success'=>false]);
            return $response;
        }
        else{

            $post=new posts;
            $post->content= $request->content;
            $post->title=$request->title;
            $post->image=$request->image;

            $post->save();
            return response()->json($post);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post=posts::find($id);
        return response()->json($post);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),
        [
         'content'=>'required'
        ]);

        if($validator->fails()){
            $response=array(['response'=>$validator->messages(),'success'=>false]);
            return $response;
        }
        else{

            $post=posts::find($id);
            $post->content= $request->content;
            $post->title=$request->title;
            $post->image=$request->image;
            $post->save();
            return response()->json($post);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post=posts::find($id);
        if ($post){
            $post->delete();
            $response=array(['response'=>'the post deleted','success'=>true]);
            return $response;

        }
        else{
            $response=array(['response'=>'the post not found','success'=>false]);
            return $response;
        }
    }
}
