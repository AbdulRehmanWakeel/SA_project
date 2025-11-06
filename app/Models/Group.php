<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable=['name'];
    
    public function permissions(){
        return $this->belongsToMany(Permission::class,'group_permission');
    }
    public function users(){
        return $this->belongsToMany(User::class,'user_group');
    }
}
