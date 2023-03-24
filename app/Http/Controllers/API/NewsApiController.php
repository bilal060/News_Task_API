<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class NewsApiController extends Controller
{
    public function getNews(Request $request)
    {
        $client = new Client();
         $apiKey = $request->input('apiKey','b2a64c534fff42809aaa65f271409db9');
         $country = $request->input('country', 'us');
        $response = $client->request('GET', 'https://newsapi.org/v2/top-headlines', [
            'query' => [
                'country' => $country,
                'apiKey' => $apiKey,
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return response()->json([
            'status' => 'ok',
            'totalResults' => $data['totalResults'],
            'articles' => $data['articles'],
        ]);
    }



    public function getNewsbyCategories(Request $request , $category)
    {
        $client = new Client();
         $apiKey = $request->input('apiKey','b2a64c534fff42809aaa65f271409db9');
         $country = $request->input('country', 'us');
        $response = $client->request('GET', 'https://newsapi.org/v2/top-headlines', [
            'query' => [
                'country' => $country,
                'apiKey' => $apiKey,
                'category'=> $category
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return response()->json([
            'status' => 'ok',
            'totalResults' => $data['totalResults'],
            'articles' => $data['articles'],
        ]);
    }



    public function index(Request $request)
{
    $client = new Client();
    $url = 'https://newsapi.org/v2/top-headlines?country=us';
    $apiKey = 'pub_193055d8bb61a01a0be30f935305b3bea935f';

    if ($request->has('author')) {
        $url .= '&author=' . $request->query('author');
    }

    if ($request->has('category')) {
        $url .= '&category=' . $request->query('category');
    }

    $response = $client->request('GET', $url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $apiKey
        ]
    ]);

    $data = json_decode($response->getBody());

    return response()->json($data);
}

};


