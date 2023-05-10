<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function getByPostID (Request $request) {
        $data =  Comment::join('users', 'comments.user_id', '=', 'users.id')
            ->select('comments.*', 'users.id as user_id', 'users.lastname',)
            ->where('post_id', $request->id)
            ->get();
        // $data =  Comment::where('post_id', $request->id)->get();
        return response()->json($data);
    }

    public function getByUserID (Request $request) {
        // $data =  Comment::join('users', 'comments.user_id', '=', 'users.id')
        //     ->select('comments.*', 'users.lastname',)
        //     ->where('post_id', $request->id)
        //     ->get();
        // // $data =  Comment::where('post_id', $request->id)->get();
        // return response()->json($data);
    }

    public function addComments (Request $request) {
        $comment = $request->all();
        if($comment = Comment::create($comment)){
            Post::find($request->post_id)->increment('number_comment');
            $response['message'] = 'Success';
            $response['data'] = $comment;
        }
        else {
            $response['message'] = 'Fail';
        }
        return response()->json($response);
    }
}