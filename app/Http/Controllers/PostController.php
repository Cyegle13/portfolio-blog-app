<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');

            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('body', 'like', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('name', 'like', '%' . $keyword . '%');
                });
            });
        }

        $posts = $query->latest()->paginate(5);

        return view('dashboard', compact('posts'));
    }

    public function create()
    {
        $post = new Post();
        return view('posts.save', compact('post'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'body' => 'required',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('dashboard')->with('success', '記事を新規登録しました。');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'この記事を編集する権限がありません。');
        }

        return view('posts.save', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'この記事を編集する権限がありません。');
        }

        $validated = $request->validate([
            'title' => 'required|max:100',
            'body' => 'required',
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post->id)->with('success', '記事を更新しました。');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'この記事を削除する権限がありません。');
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', '記事を削除しました。');
    }
}
