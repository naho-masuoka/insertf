<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Department;
use App\File;
use Auth;

class Genre_file extends Model
{
    protected $fillable = ['department_id', 'sort_no', 'name'];

    public function departments(){
        return $this->belongsTo(Department::Class);
    }

    public function files(){
        return $this->hasMany(File::Class);
    }

    /**
     * この書類ジャンルが閲覧許可を出している部署（Departmentモデルとの関係を定義）
     */
    public function viewings(){
        $id=auth::user()->department_id;
        return $this->belongsToMany(Department::Class,'genre_files_departments','genre_file_id', 'department_id')->where('department_id',$id)->withTimestamps();
    }
    public function is_viewings(){
        $id=auth::user()->department_id;
        $exist=$this->viewings()->where('department_id',$id)->exists();
        return $exist;
    }
}
