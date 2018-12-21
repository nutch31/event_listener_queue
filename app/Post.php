<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = "posts";
    protected $fillable = ["post_name", "post_detail", "status", "profile_id", "created_at", "updated_at"];
}
