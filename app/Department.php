<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Document;
use App\Item;
use App\User;
use App\Genre_file;
use Auth;

class Department extends Model
{
    public function users(){
        return $this->hasMany(User::class);
    }
    
    public function departmentname($id){
        $name=Department::find($id);
        return $name;
    }

    public function documents(){
        return $this->hasMany(Document::Class);
    }

    public function genre_fils(){
        return $this->hasMany(Genre_file::Class);
    }

    public function items($id){
        return $this->hasMany(Item::Class)->where('project_id',$id)->whereNUll('claim_id')->whereNUll('genre_id');
    }
    /**
     * 部署がフォロー中の書類ジャンル（ Genre_fileモデルとの関係を定義）
     */
    public function followings(){
        return $this->belongsToMany(Genre_file::Class,'genre_files_departments','department_id','genre_file_id')->withTimestamps();
    }

}
