<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contact extends Model

{
    use SoftDeletes;
    protected $fillable=[
        'user_id',
        'name',
        'email',
        'message',
        'image'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
