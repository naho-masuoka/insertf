<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Department;


class Document extends Model
{
    public function department(){
        return $this->belongsTo(Department::Class);
    }
}
