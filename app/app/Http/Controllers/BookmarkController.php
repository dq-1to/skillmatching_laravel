<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function store(Post $post, Request $request)
    {
        try {
            $request->user()->bookmarks()->syncWithoutDetaching([$post->id]);
            return response()->json([
                'ok' => true,
                'bookmarked' => true,
                'count' => $post->bookmarkedBy()->count(),
            ]);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['ok' => false, 'message' => 'failed to bookmark'], 500);
        }
    }

    public function destroy(Post $post, Request $request)
    {
        try {
            $request->user()->bookmarks()->detach($post->id);
            return response()->json([
                'ok' => true,
                'bookmarked' => false,
                'count' => $post->bookmarkedBy()->count(),
            ]);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['ok' => false, 'message' => 'failed to unbookmark'], 500);
        }
    }
}