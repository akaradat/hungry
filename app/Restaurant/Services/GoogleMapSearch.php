<?php

namespace App\Restaurant\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GoogleMapSearch
{
    private $key; // google map api key
    private $cacheTime; // cache time
    const URL = 'https://maps.googleapis.com/maps/api/place/textsearch/json';

    /**
     * Google map restaurants search
     * @constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $key = env('MAP_API_KEY', null);
        // if key doesn't provide then throw an error
        if (empty($key)) {
            throw new Exception("not provide google map api key", 1);
        }

        $this->key = $key;
        $this->cacheTime = env('CAHCE_TIME_SEC', 86400); // set cache time in section
    }

    /**
     * Find nearby restaurants
     *
     * @param  string $location - location to search
     * @return object result of restaurants list
     */
    public function findRestaurantByText($location)
    {
        // return data in cache if exist
        if (Cache::has($location)) {
            return Cache::get($location);
        }

        // query data from google api
        $result = $this->queryDataFromGoogleMapApi([
            'key' => $this->key,
            'query' => $location,
            'types' => 'restaurant',
            'region' => 'th',
        ]);

        // if search result is usable then store in cache
        if ($result['status'] === 'OK') {
            Cache::put($location, $result, $this->cacheTime);
        }

        return $result;
    }

    public function findNextPage($nextPageToken)
    {
        // using hashed of next_page_token as key in cache to reduct key length
        // next_page_token is more than 400 characters long
        // md5 is 32 characters long
        $cacheKey = md5($nextPageToken);

        // return data in cache if exist
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // query data from google api
        $result = $this->queryDataFromGoogleMapApi([
            'key' => $this->key,
            'pagetoken' => $nextPageToken
        ]);

        // if search result is usable then store in cache
        if ($result['status'] === 'OK') {
            Cache::put($cacheKey, $result, $this->cacheTime);
        }

        return $result;
    }

    /**
     * Search place by google map api
     *
     * @param  array $params - get parameter for query
     * @return object result of api call
     */
    private function queryDataFromGoogleMapApi($params)
    {
        $response = Http::get(self::URL, $params);

        $res = $response->json();
        // check response is OK
        if ($res['status'] !== 'OK') {
            return [
                'status' => 'error',
                'error_message' => 'something error'
            ];
        }

        // mapping result data of each places to filter only needed fields
        $neededResult = collect($res['results'])->map(function ($place) {
            return [
                'place_id' => $place['place_id'],
                'name' => $place['name'],
                'rating' => $place['rating'],
                'user_ratings_total' => $place['user_ratings_total'],
                'photo_reference' => $place['photos'][0]['photo_reference'] ?? null,
            ];
        });

        $searchDataRes = [
            'status' => 'OK',
            'results' => $neededResult,
            'next_page_token' => $res['next_page_token'] ?? null,
            'query_time' => now()
        ];

        return $searchDataRes;
    }
}
