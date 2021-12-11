<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hr_manager extends Model
{
    protected $table = 'hr_manager';
    protected $fillable = ['user_id','name'];
}
