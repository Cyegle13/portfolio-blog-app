<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required',
            'comment' => 'required',
        ]);

        Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('posts.show', $validated['post_id'])->with('success', 'コメントを追加しました。');
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'この記事を編集する権限がありません。');
        }

        $validated = $request->validate([
            'comment' => 'required',
        ]);

        $comment->update($validated);

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'コメントを編集しました。');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'この記事を削除する権限がありません。');
        }

        $comment->delete();

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'コメントを削除しました。');
    }
}
