<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    private $validOrderFields = ['id', 'votes_count', 'created_at', 'updated_at'];
    private $validOrderMethods = ['desc', 'asc'];
    private $defaultPaginationItemsCount = 25;
    private $defaultPostOrderField = 'created_at';
    private $defaultPostOrderMethod = 'desc';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $request->validate([
            'orderBy' => [
                'required_with:orderByMethod',
                Rule::in($this->validOrderFields)
            ],
            'orderByMethod' => [
                'required_with:orderBy',
                Rule::in($this->validOrderMethods)
            ],
        ]);

        $orderBy = $request->input('orderBy', $this->defaultPostOrderField);
        $orderByMethod = $request->input('orderByMethod', $this->defaultPostOrderMethod);

        return PostResource::collection(Post::withCount('votes')->orderBy($orderBy, $orderByMethod)->paginate($this->defaultPaginationItemsCount));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'author_name' => $request->input('author.name'),
            'author_email' => $request->input('author.email'),
        ]);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        $post->loadCount('votes');

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $post->votes()->delete();
        $post->delete();

        return response()->json(['message' => "Successfully deleted post with id: {$post->id}"], 200);
    }

    public function upVote(Post $post)
    {
        Vote::create(['post_id' => $post->id]);

        $post->refresh()->loadCount('votes');

        return new PostResource($post);
    }
}
