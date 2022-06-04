<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\curd;
use Illuminate\Support\Facades\DB;
// use App\Models\blog;
// use App\Models\product;
// use App\Models\empl;

class indexController extends Controller
{

     // for view post page 
     function welcome()
     {
         $post = curd::all();
         return view('welcome',['post'=>$post]);
     }

    // for view form page 
    function view()
    { 
        return view('index');
    }

    // for create 
    function curd_post(Request $req){

        $post= new curd;
        $post -> title= $req -> title;
        $post -> post= $req -> post;
        $post -> description= $req -> description;

        $post -> save();

        return redirect('/index');
    }

  

    // for view edit page
    function edit_curd($id){
        $data=curd::find($id);
        // $data->delete();
        return view('editForm',['data'=>$data]);
    }

    // update page 

    function update_curd(Request $req )
    {
        // return $req->input();
        $update=curd::find($req->id);
        
        $update -> title= $req -> title;
        $update -> post= $req -> post;
        $update -> description= $req -> description;

        $update-> save();
        return redirect('/');

    }

     // for delete
    function delete_curd($id){
        $data=curd::find($id);
        $data->delete();
        return redirect('/');
    }

}
