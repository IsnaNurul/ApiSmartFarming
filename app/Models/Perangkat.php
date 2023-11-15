<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;
    protected $table = "perangkats";
    protected $guarded = "";

    function kebun(){
        return $this->hasMany(Kebun::class, 'id');
    }

    function user(){
        return $this->belongsTo(user::class, 'id_user');
    }
}
