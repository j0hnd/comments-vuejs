<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComments extends Model
{
	protected $fillable = ['parent_id', 'child_id', 'source'];

	protected $table = 'post_comment';

	public $timestamps = true;
}
