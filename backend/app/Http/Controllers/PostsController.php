<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    public function getAlls () {
        $PostModal =  new Post();
        $data = $PostModal->getAlls();
        return response()->json($data);
    }

    public function getByID (Request $request) {
        $data =  Post::where('id', $request->id)->first();
        return response()->json($data);
    }

    public function addPost (Request $request) {
        if($request->hasFile('image')){
            $completeFileName = $request->file('image')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extenshion = $request->file('image')->getClientOriginalExtension();
            $completePicture = str_replace(' ', '_', $fileNameOnly).'-'.rand().'-'.time().'.'.$extenshion;
            $path = $request->file('image')->storeAs('public/storage', $completePicture);
        }
        return response()->json($request);
    }
}