<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\Item;
use App\department;

class Claim extends Model
{
    protected $dates   = ['workingday',];
    protected $fillable = ['project_id', 'machineid', 'department_id', 'workingday', 'memo',];
    
    
    public function Project(){
        return $this->belongsTo(Project::Class);
    }

    public function items(){
        return $this->hasMany(Item::Class);
    }

    public function departments(){
        return $this->belongsTo(Department::Class);
    }
}
