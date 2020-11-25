<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    protected $apiKey;

    public function __construct() {
        $this->apiKey = env('TMDB_KEY');
    }

    public function get(Request $request) {
        $request->validate([
            'filter' => 'required|string',
            'page' => 'required|integer'
        ]);

        $filter = $request->get('filter');
        $page = $request->get('page');

        try {
            $link = "https://api.themoviedb.org/3/movie/$filter?page=$page&api_key=$this->apiKey";
            $movies = Http::get($link);
            return response()->json(['status' => 'success', 'movies' => $movies->json()], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function search(Request $request) {
        $request->validate([
            'query' => 'string',
            'page' => 'required|integer'
        ]);

        $query = $request->get('query');
        $page = $request->get('page');

        try {
            $link = "https://api.themoviedb.org/3/search/movie/?page=$page&query=$query&api_key=$this->apiKey";
            $movies = Http::get($link);
            return response()->json(['status' => 'success', 'movies' => $movies->json()], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function getSingle(Request $request) {
        $request->validate([
            'movie_id' => 'required|integer'
        ]);

        $movieId = $request->get('movie_id');

        try {
            $link = "https://api.themoviedb.org/3/movie/$movieId?api_key=$this->apiKey";
            $movie = Http::get($link);
            return response()->json(['status' => 'success', 'movie' => $movie->json()], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
