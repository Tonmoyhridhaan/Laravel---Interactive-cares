<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function shorten(Request $request)
    {
        $user = $request->user;
        //dd($request);
        $long_url = $request->long_url;
        $request->validate([
            'long_url' => 'required|url'
        ]);

        $url = Url::firstOrCreate(
            ['user_id' => $user->id, 'long_url' => $request->long_url],
            ['short_url' => Str::random(6)]
        );
        

        return response()->json(['short_url' => $url->short_url], 200);
    }

    public function listUserUrls(Request $request)
    {
        // Access the authenticated user
        $user = $request->user;
        //dd($user);
        // Check if the user is null
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Get all URLs created by the user
        $urls = $user->urls;
        return response()->json($urls, 200);
    }

    public function redirectUrl($short_url)
    {
        $url = Url::where('short_url', $short_url)->firstOrFail();
        $url->increment('visit_count');
        return redirect($url->long_url);
    }
}
