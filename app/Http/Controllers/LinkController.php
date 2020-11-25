<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Movie;

class LinkController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'movies' => 'required|array'
        ]);

        $movies = $request->get('movies');

        try {
            $link = Link::create(['link' => $this->generateUniqueLink()]);
            foreach ($movies as $movie) {
                $link->movies()->create(['movie_id' => $movie]);
            }
            return response()->json(['status' => 'success', 'link' => $link->link], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function get(Request $request) {
        $request->validate([
            'link' => 'required|string|min:8|max:8'
        ]);

        $link = $request->get('link');

        try {
            $link = Link::where('link', $link)->first();
            if ($link === null) throw new \Exception('That link doesnt exist');

            $movies = $link->movies()->get();
            if ($movies->isEmpty()) throw new \Exception('There are no movies for that link');

            return response()->json(['status' => 'success', 'movies' => $movies], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }



    private function generateUniqueLink() {
        $length = 8;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
