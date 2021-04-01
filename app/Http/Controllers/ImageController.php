<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request){

        $validate = $this->validate($request,[
            'description' => 'required',
            'image_path'  => 'required|mimes:jpg,jpeg,png,bmp|max:20000'    
        ],[
            'required'=>':attribute es obligatorio',
            'image_path.mimes'=>'Este campo solo admite imágenes',
        ]);

        $image_path=$request->file('image_path');
        $description = $request->input('description');
        
        $image = new Image();
        $image->description = $request->input('description');
        $image->user_id= Auth::user()->id;  

       
        $image_path_name = $image->user_id."-".time()."-".$image_path->getClientOriginalName();
        Storage::disk('images')->put($image_path_name, File::get($image_path));
       
        $image->image_path= $image_path_name;
        

        $image->save();

        return \redirect()->route('home')
                          ->with(['message'=>'Imagen subida correctamente'])
        ;

    }

    public function getimage($filename){
        $file = Storage::disk('images')->get($filename);

        return new Response($file,200);
    }

    public function detail($id){
       
        $image = Image::find($id);
        
        return view('image.detail',[
            'image'=>$image
        ]);
    }

    public function delete($image_id){
        $user=Auth::user();
        $image=Image::find($image_id);

        if($image && ($image->user_id == $user->id)){         
            
            if($image->image_path){
                Storage::disk('images')->delete($image->image_path);
            }

            $image->delete();
            return \redirect()->route('home')
                              ->with(['message'=>'Imagen eliminada correctamente'])
            ;      
        }else{
            return \redirect()->route('home')
                              ->with(['message'=>'No se pudo eliminar la Imagen'])
            ; 
        }

    }

    public function edit($image_id){

        $user=Auth::user();
        $image=Image::find($image_id);
        

        if($user && $image && ($image->user_id == $user->id) ){
            return view('image.edit', ['image'=>$image]);
        }else{
            return \redirect()->route('home')
                              ->with(['message'=>'Error Al Acceder']) 
            ; 
        }
    }

    public function update(Request $request){

        $user = Auth::user();

        $validate = $this->validate($request,[
            'description' => 'required',
            'image_path'  => 'mimes:jpg,jpeg,png,bmp|max:20000',
            'image_id'    => 'required'
        ],[
            'required'=>'La descripción es obligatoria',
            'image_path.mimes'=>'Este campo solo admite imágenes',
        ]);

        $image_path=$request->file('image_path');
        $description = $request->input('description');
        $image_id = $request->input('image_id');

        // var_dump($image_path);
        // var_dump($description);
        // var_dump($image_id);

        $image=Image::find($image_id);

        if($user && $image && ($image->user_id == $user->id) ){
            
            $image->description = $description;

            if($image_path){
                //Delete Image
                if($image->image_path){
                    Storage::disk('images')->delete($image->image_path);
                }

                //Upload Image
                $image_path_name = $image->user_id."-".time()."-".$image_path->getClientOriginalName();
                Storage::disk('images')->put($image_path_name, File::get($image_path));
                
                //Insert path in Object
                $image->image_path= $image_path_name;
            }

            //Update Db registry
            $image->update();

            return \redirect()->route('image.detail',['id'=>$image->id])
                              ->with(['message'=>'Imagen Actualizada con éxito']) 
            ; 

        }else{
            return \redirect()->route('home')
                              ->with(['message'=>'Error Al Acceder']) 
            ; 
        }


        

    }
}
