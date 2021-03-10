<?php

namespace App\Http\Controllers;

use App\Http\Requests\SortGetRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    /**
     * Display all post
     *
     * @param SortGetRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(SortGetRequest $request)
    {
        $sort = $request->input('sort') ?? 'desc';
        $posts = Post::orderBy('published', $sort)->paginate(10)->withQueryString();
        return view('index', ['posts'=> $posts]);
    }

    /**
     * Display single post
     *
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Post $post)
    {
        return view('post', ['post' => $post]);
    }
}
