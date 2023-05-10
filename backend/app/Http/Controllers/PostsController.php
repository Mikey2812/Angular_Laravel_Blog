<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;

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

    public function getByUserID (Request $request) {
        
        $data =  Post::where('user_id', $request->id)->get();
        return response()->json($data);
    }

    public function addPost (Request $request) {
        $post = $request->all();
        if($request->hasFile('image')){
            $completeFileName = $request->file('image')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extenshion = $request->file('image')->getClientOriginalExtension();
            $completePicture = str_replace(' ', '_', $fileNameOnly).'-'.rand().'-'.time().'.'.$extenshion;
            $request->file('image')->storeAs('public/storage/posts', $completePicture);
        }
        $post['image'] = 'posts/'.$completePicture;
        if(Post::create($post)){
            Topic::find($request->topic_id)->increment('number_post');
            $response['message'] = 'Success';
        }
        else {
            $response['message'] = 'Fail';
        }
        return response()->json($response);
    }

    public function editPost (Request $request) {
        $post = $request->all();
        $id = $request->id;
        $postData = Post::where('id', $id)->first();
        if ($postData) {
            $filename = $postData->image;
        }
        if (Storage::exists('public/storage/'.$filename)) {
            Storage::delete('public/storage/'.$filename);
        }   
        if($request->hasFile('image')){
            $completeFileName = $request->file('image')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extenshion = $request->file('image')->getClientOriginalExtension();
            $completePicture = str_replace(' ', '_', $fileNameOnly).'-'.rand().'-'.time().'.'.$extenshion;
            //loi
            $request->file('image')->storeAs('public/storage/posts', $completePicture);
        }
        $post['image'] = 'posts/'.$completePicture;
        if($postData->update($post)){
            $response['id'] = $id;
            $response['message'] = 'Success';
        }
        else {
            $response['message'] = 'Fail';
        }
        return response()->json($response);
    }

    public function delPost (Request $request) {
        $id = $request->id;
        $postData = Post::where('id', $id)->first();
        if ($postData) {
            $topic_id = $postData->topic_id;
            $filename = $postData->image;
        }
        if (Storage::exists('public/storage/'.$filename)) {
            Storage::delete('public/storage/'.$filename);
        }   
        if($postData->delete()){
            Topic::find($topic_id)->decrement('number_post');
            $response['id'] = $id;
            $response['message'] = 'Success';
        }
        else {
            $response['message'] = 'Fail';
        }
        return response()->json($response);
    }
}