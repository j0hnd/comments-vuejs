<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
	public $fillable = ['post_id', 'user_id', 'comment'];

	public $dates = ['created_at', 'updated_at'];

	public $timestamps = true;


	public function posts()
	{
		return $this->belongsToMany('App\Post', 'post_comment', 'parent_id', 'child_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id')->pluck('name');
	}
}
