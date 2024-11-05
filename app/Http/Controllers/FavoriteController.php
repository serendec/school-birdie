<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->latest()->paginate(10);
        
        return view('favorite.index', compact('favorites'));
    }

    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
                            ->where('video_category', $request->video_category)
                            ->where('video_category_id', $request->video_category_id)
                            ->where('video', $request->video)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'unfavorited']);
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'video_category' => $request->video_category,
                'video_category_id' => $request->video_category_id,
                'video' => $request->video,
            ]);
            return response()->json(['status' => 'favorited']);
        }
    }
}
