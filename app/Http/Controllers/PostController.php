<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Posts;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
	public function index()
	{
		return view('post.index');
	}

    public function fetch()
	{
		if (! request()->ajax()) {
			return null;
		}

		$posts = Posts::all();

		$data = null;

		if ($posts->isNotEmpty()) {
			foreach ($posts as $post) {
				$data[] = [
					'id' => $post->id,
					'title' => $post->title,
					'user' => $post->user()->pluck('name')[0],
					'posted_at' => $post->created_at->format('F d, Y h:i A'),
					'no_comments' => $post->comments()->count()
				];
			}
		}

		return collect($data);
	}

	public function getPost($post_id)
	{
		if (! request()->ajax()) {
			return null;
		}

		$post = Posts::findOrFail($post_id);

		$data = null;

		if ($post) {
			$data = [
				'id' => $post->id,
				'title' => $post->title,
				'user' => $post->user()->pluck('name')[0],
				'post' => $post->post,
				'no_comments' => $post->comments()->count(),
				'comments' => $post->comments()->get(),
				'posted_at' => $post->created_at->format('F d, Y')
			];
		}

		return collect($data);
	}

	public function save(PostFormRequest $request, Posts $posts)
	{
		if (! request()->ajax()) {
			return null;
		}

		$fillable = $request->only(['title', 'post']);

		$posted_by = $request->get('user');

		$user_id = 0;

		$response = ['success' => false];


		if (! empty($posted_by)) {
			$user_id = (User::where(['name' => $posted_by])->first())->id;
		}

		$fillable['user_id'] = $user_id;

		$posts->fill($fillable);

		if ($posts->save()) {
			$response['success'] = true;
		}

		return response()->json($response);
	}
}
