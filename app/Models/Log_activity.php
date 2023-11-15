<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_activity extends Model
{
    use HasFactory;
    protected $table = "log_activities";
    protected $guarded = "";

    function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
