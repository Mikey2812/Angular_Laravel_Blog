<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'title',
        'description',
        'content',
        'image',
    ]; 

    public function getAlls(){
        $data = DB::table('posts')->get();
        return $data;
    }

    // public function getByID(id){
    //     $data = DB::table('posts')->get();
    //     return $data
    // }
}