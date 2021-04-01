<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
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
    
    public function config(){
        return view('user.config');
    }

    public function update(Request $request){
        $user = Auth::user();
        $id= $user->id;

        $validate = $this->validate($request,[
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id
        ]);

        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //upload image
        $image_path=$request->file('image_path');
        if($image_path){
            $image_path_name = time()."-".$image_path->getClientOriginalName();
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            $user->image= $image_path_name;
        }

        $user->update();

        return \redirect()->route('config')
                          ->with(['message'=>'Usuario actualizado correctamente'])
        ;
    }
    
    public function getimage($filename){
        $file = Storage::disk('users')->get($filename);

        return new Response($file,200);
    }

    public function profile($user_id)
    {
        $user= User::find($user_id);

        if($user){
            return view('user.profile',['user'=>$user]);
        }else{
            return \redirect()->route('home');
        }
    }

    public function users($search=null)
    {
        if(!empty($search)){

            $users= User::where(function ($query) use($search){         
                $query->where('nick','like','%'.$search.'%')
                      ->orWhere('name','like','%'.$search.'%')
                      ->orWhere('surname','like','%'.$search.'%');
            })
                ->orderBy('id','desc')
                ->paginate(5)
            ;

               
        }else{

            $users= User::orderBy('id','desc')->paginate(5);
        }

        return view('user.index',['users'=>$users]);
    }
}

