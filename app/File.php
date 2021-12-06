<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['genre_file_id','name','branch','extension','submission'];
}
