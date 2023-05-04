<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function getAlls () {
        $TopicModal =  new Topic();
        $data = $TopicModal->getAlls();
        return response()->json($data);
    }
}