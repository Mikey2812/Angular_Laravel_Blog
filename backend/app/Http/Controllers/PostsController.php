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
}