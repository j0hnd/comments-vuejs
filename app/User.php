<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name'];

	protected $dates = ['created_at', 'updated_at'];

	public $timestamps = true;


	public function posts()
	{
		return $this->hasMany(Posts::class, 'id', 'user_id');
	}
}
