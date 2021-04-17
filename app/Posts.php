<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
	protected $fillable = ['user_id', 'title', 'post'];

	protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;


    public function comments()
	{
		return $this->belongsToMany('App\Comments', 'post_comment', 'parent_id', 'child_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
