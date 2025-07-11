<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }


    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post = $request->user()->posts()->create($fields);

        return [ 'post' => $post ];
    }


    public function show(Post $post)
    {
        return $post;
    }


    public function update(Request $request, Post $post)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post->update($fields);

        return [ 'post' => $post ];
    }


    public function destroy(Post $post)
    {
        $post->delete();

        return [ 'message' => "O post foi deletado" ];
    }
}
