<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\Url;
use App\Vtuber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{

    public function index()
    {
        //
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        foreach ($posts as $post) {
            $post->tag;
        }
        return view('postindex', ['posts' => $posts]);
    }

    public function index_clip()
    {
        //
        $posts = Post::where('type', '=', 'Clip')->orderBy('created_at', 'desc')->paginate(5);
        foreach ($posts as $post) {
            $post->tag;
        }
        return view('clipindex', ['posts' => $posts]);
    }

    public function index_picture()
    {
        //
        $posts = Post::where('type', '=', 'Picture')->orderBy('created_at', 'desc')->paginate(5);
        foreach ($posts as $post) {
            $post->tag;
        }
        return view('pictureindex', ['posts' => $posts]);
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->type = $request->type;
        $post->title = $request->title;
        $post->content = $request->content;
        //if youtu.be
        if (strpos($request->content, 'youtu.be') !== false) {
            // Provides: You should eat pizza, beer, and ice cream every day
            $phrase  = $request->content;
            $tobe_replaced = array("youtu.be/");
            $replacing   = array("www.youtube.com/watch?v=");
            $newphrase = str_replace($tobe_replaced, $replacing, $phrase);
            $post->content = $newphrase;
        }

        $post->caption = $request->caption;
        $post->created_at = now();
        $post->updated_at = now();
        $post->save();

        //tag
        $tags = $request->tags;
        $tags_array = explode(", ", $tags);
        foreach ($tags_array as $tagname) {
            $tag = new Tag;
            $tag->id_post = $post->id;
            $tag->tagname = $tagname;
            $tag->save();
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $key = $request->input('key');
        if ($key == null) {
            return redirect()->back();
        }
        //without paginate
        $posts = Post::whereHas('tag', function ($query) use ($key) {
            $query->where('tagname', 'like', "%$key%");
        })->orWhere('title', 'like', "%$key%")
            ->orWhere('caption', 'like', "%$key%")
            ->orderBy('created_at', 'desc')->get();
        foreach ($posts as $post) {
            $post->tag;
        }
        //count
        $posts_count = $posts->count();

        //with paginate
        $posts = Post::whereHas('tag', function ($query) use ($key) {
            $query->where('tagname', 'like', "%$key%");
        })->orWhere('title', 'like', "%$key%")
            ->orWhere('caption', 'like', "%$key%")
            ->orderBy('created_at', 'desc')->paginate(5);
        return view('searchresult', ['posts' => $posts, 'posts_count' => $posts_count, 'key' => $key]);
    }

    public function searchtag($tag)
    {
        //without paginate
        $posts = Post::whereHas('tag', function ($query) use ($tag) {
            $query->where('tagname', '=', $tag);
        })->orderBy('created_at', 'desc')->get();
        //count
        $posts_count = $posts->count();

        //with paginate
        $posts = Post::whereHas('tag', function ($query) use ($tag) {
            $query->where('tagname', '=', $tag);
        })->orderBy('created_at', 'desc')->paginate(5);
        return view('searchbytag', ['posts' => $posts, 'tag' => $tag, 'posts_count' => $posts_count]);
    }

    public function show($id)
    {
        //
        $post = Post::find($id);
        $post->tag;
        return $post;
    }

    public function singlepost($id)
    {
        //
        $post = Post::find($id);
        $post->tag;
        return view('singlepost', ['post' => $post]);
    }

    public function update(Request $request)
    {
        //
        $post = Post::find($request->id_post);
        $post->type = $request->type;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->caption = $request->caption;
        $post->updated_at = now();
        $post->save();

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        //delete tag
        $tag = Tag::where('id_post', '=', $request->id_post);
        $tag->delete();

        //delete post
        $post = Post::find($request->id_post);
        $post->delete();
        return redirect()->route('front');
    }
}
