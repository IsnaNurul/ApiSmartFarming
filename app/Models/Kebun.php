<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebun extends Model
{
    use HasFactory;
    protected $table = "kebuns";
    protected $guarded = "";

    function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    function tanaman(){
        return $this->belongsTo(Tanaman::class, 'id_tanaman');
    }

    function perangkat(){
        return $this->belongsTo(Perangkat::class, 'id_perangkat');
    }
}
