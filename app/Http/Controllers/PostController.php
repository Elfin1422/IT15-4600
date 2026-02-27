<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all(); //Get all posts from database

        return view('posts.index', compact('posts'));
    }
}