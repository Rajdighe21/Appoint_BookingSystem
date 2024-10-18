<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    protected $fillable = [
        'user_id',
        'image',
        'specialization',
        'contact',
    ];


    protected $table = 'doctors';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
