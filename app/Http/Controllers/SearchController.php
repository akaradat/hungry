<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Restaurant\Services\GoogleMapSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string',
        ]);

        // searching for restaurants nearby provided location
        $mapSearch = new GoogleMapSearch();
        $result = $mapSearch->findRestaurantByText($validated['query']);

        return response()->json($result);
    }

    public function next(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        // searching for next page of previous result
        $mapSearch = new GoogleMapSearch();
        $result = $mapSearch->findNextPage($validated['token']);

        return response()->json($result);
    }
}
