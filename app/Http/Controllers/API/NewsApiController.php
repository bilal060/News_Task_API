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

public function filterByAuthor(Request $request ,$authorName)
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
    $articles = $data['articles'];
    $filtered_articles = [];

    foreach ($articles as $article) {
        if ($article['author'] === $authorName) {
            $filtered_articles[] = $article;
        }

    }
    return response()->json($filtered_articles);





}


};
