<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Claim;
use App\Department;
class Item extends Model
{
    protected $fillable = ['department_id', 'project_id', 'claim_id','name','branch','extension','genre','genre_id'];

    public function claim(){
        return $this->belongsTo(Department::Class);
    }

    public function department(){
        return $this->belongsTo(Department::Class);
    }
}
