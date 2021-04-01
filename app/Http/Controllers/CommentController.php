<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create(Request $request){

        $validate = $this->validate($request,[
            'image_id' => 'required',
            'content'  => 'required|string'    
        ],[
            'required'=>':attribute es obligatorio',
            
        ]);

        $image_id= $request->input('image_id');
        $content= $request->input('content');
        $user_id= Auth::user()->id;

        $comment= new Comment();
        $comment->user_id=$user_id;
        $comment->image_id=$image_id;
        $comment->content=$content;

        $comment->save();

        return \redirect()->route('image.detail',['id'=>$image_id]);
    } 

    public function deleteById($id_comment){

        $user = Auth::user();
        $comment=Comment::find($id_comment);
        $image_id= $comment->image_id;

        if($user && ($user->id == $comment->user_id)){
            $comment->delete();
        }

        return \redirect()->route('image.detail',['id'=>$image_id]);
    }
}
