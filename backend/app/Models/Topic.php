<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Topic extends Model
{
    use HasFactory;
    
    public function getAlls(){
        $data = DB::table('topics')->get();
        return $data;
    }
}