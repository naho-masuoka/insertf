<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Project;

class Customer extends Model
{
    protected $dates   = ['updateday',];
    protected $fillable = ['project_id', 'customer', 'enduser', 'updateday'];
    
    public function project(){
        return $this->belongsTo(Project::Class);
    }
}
