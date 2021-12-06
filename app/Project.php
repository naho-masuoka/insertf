<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Claim;
use App\Customer;
use App\Item;


class Project extends Model
{
    protected $fillable = ['prepareid', 'projectid', 'machineid', 'customer','enduser','keywords',];


    public function customers(){
        return $this->hasMany(Customer::Class);
    }

    public function claims(){
        return $this->hasMany(Claim::Class);
    }
    public function items(){
        return $this->hasMany(Item::Class)->whereNull('genre_id')->whereNull('claim_id');
    }
    public function claim_items(){
        return $this->hasMany(Item::Class)->whereNull('genre_id')->whereNotNull('claim_id');
    }
    public function finaldocuments(){
        return $this->hasMany(Item::Class)->where('genre_id',1);
    }
}
