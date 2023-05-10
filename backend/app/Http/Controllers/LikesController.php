<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function getByUserID (Request $request) {
        $user_id = $request->user_id;
        $type = $request->type;
        $data =  Like::where('user_id', $user_id)
                        ->where('type', $type)
                        ->get();
        return response()->json($data);
    }

    public function addLike (Request $request) {
        $type = intval($request->type);
        $location_id = intval($request->location_id);
        $likeData = $request->all();
        $data = Like::create($likeData);
        if ($type == 0) {
            Post::find($location_id)->increment('number_like');
        }
        else {
            Comment::find($location_id)->increment('number_like');
        }
        if($data) {
            $response['message'] = 'Success';
        }
        return response()->json($response);
    }

    public function delByLocationID (Request $request) {
        $location_id = $request->location_id;
        $type = $request->type;
        $data =  Like::where('location_id', $location_id)
                        ->where('type', $type)
                        ->delete();
        if ($type == 0) {
            Post::find($location_id)->decrement('number_like');
        }
        else {
            Comment::find($location_id)->decrement('number_like');
        }
        if($data) {
            $response['message'] = 'Success';
        }
        return response()->json($response);
    }
}