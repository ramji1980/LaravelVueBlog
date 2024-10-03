<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\Post\StoreRequest;
use Inertia\Inertia;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $postModel;

    public function __construct(Post $postModel){
        $this->postModel=$postModel;
    }

    public function index():\Inertia\Response
    {
        return Inertia::render('Post/List', 
        ['posts' => $this->postModel->getPosts(),
        'message'=>session('message'),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Post/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $postValidated = $request->validated();
        $createPost = Post::create($postValidated);

        if ($createPost) {
            return redirect()->route('posts.index')->with('message', 'Post Created Successfully');
        }

        return abort(500);
    }
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return Inertia::render('Post/Show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return Inertia::render('Post/Form', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Post $post)
    {
        $postValidated = $request->validated();
        $updatePost = $post->update($postValidated);
    
        if ($updatePost) {
            return redirect()->route('posts.index')->with('message', 'Post Updated Successfully');
        }
    
        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
{
    try {
        $post->delete();
        return redirect()->route('posts.index')->with('message', 'Post Deleted Successfully');
    } catch (\Exception $e) {
        return redirect()->route('posts.index')->with('error', 'Failed to delete the post');
    }
}
}
