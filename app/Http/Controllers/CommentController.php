<?php

namespace App\Http\Controllers;

use App\Comments;

use App\Posts;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\CommentFormRequest;

class CommentController extends Controller
{
    public function save(CommentFormRequest $request, Comments $comments, User $user)
	{
		if (! request()->ajax()) {
			return null;
		}

		$fillable = $request->only(['comment']);

		$posted_by = $request->get('user');

		$user_id = 0;

		$response = ['success' => false];

		if ($user_id == 0 and $posted_by) {
			$user_id = (User::where(['name' => $posted_by])->first())->id;
		}

		if ($user_id == 0 and ! empty($posted_by)) {
			$user->fill(['name' => $posted_by]);

			if ($user->save()) {
				$user_id = $user->id;
			}
		}

		$fillable['user_id'] = $user_id;

		$comments->fill($fillable);

		if ($comments->save()) {
			$post = Posts::findOrFail($request->get('parent_id'));

			$post->comments()->attach($post->id, [
				'child_id' => $comments->id,
				'source' => 'post',
			]);

			$response = [
				'success' => true,
				'parent_id' => $post->id
			];
		}

		return response()->json($response);
	}
}
