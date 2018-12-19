<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $table = "profiles";
    protected $fillable = ["title", "first_name", "last_name", "age", "height", "tall", "address", "created_at", "updated_at"];
}
