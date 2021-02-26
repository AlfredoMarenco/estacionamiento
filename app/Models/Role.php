<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    //Relacion uno a muchos inversa
    public function users(){
        return $this->belongsTo(User::class);
    }
}
