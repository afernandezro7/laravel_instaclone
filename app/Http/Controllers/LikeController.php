<?php

namespace App\Http\Controllers;

use App\Like;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
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
    
    public function index()
    {
        $user_id= Auth::user()->id;
        $likes = Like::where('user_id',$user_id)->orderBy('id','desc')->paginate(5);
        

        return view('like.index',['likes'=>$likes]);
    }

    public function like($image_id)
    {
        
        $user= Auth::user();
        $like= new Like();

        $islike=Like::where('image_id',$image_id)
                ->where('user_id',$user->id)
                ->get()
        ;

        if(count($islike)>0){

            $likeTodelete=$islike[0];
            $likeTodelete->delete();

            $likes=count(Image::find($image_id)->likes);

            return response()->json([
                'ok'=>true,
                'like'=>false,
                'count'=>$likes
            ], 200 );
            
        }else{
            
            $like->user_id= $user->id;
            $like->image_id= $image_id;
            $like->save();

            $likes=count(Image::find($image_id)->likes);

            return response()->json([
                'ok'=>true,
                'like'=>true,
                'count'=>$likes
            ], 200 );
        }

    }
    

}
