<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;



class HomeController extends Controller
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
        $images = Image::orderBy('id','desc')->paginate(5);
        

        return view('home',['images'=>$images,'is_like'=>false]);
    }
}
