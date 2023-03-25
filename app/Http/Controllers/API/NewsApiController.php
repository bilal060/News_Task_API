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
         $apiKey = $request->input('apiKey','8384ec7944444d4183eff4e85d2f530e');
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
         $apiKey = $request->input('apiKey','8384ec7944444d4183eff4e85d2f530e');
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

public function getNewsbyAuthor(Request $request ,$authorName)
{
    print_r($authorName);
    $client = new Client();
    $apiKey = $request->input('apiKey','8384ec7944444d4183eff4e85d2f530e');
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



public function filterByCategoryandAuthor(Request $request, $category ,$authorName)
{
    print_r($authorName);
    $client = new Client();
    $apiKey = $request->input('apiKey','8384ec7944444d4183eff4e85d2f530e');
    $country = $request->input('country', 'us');
    $response = $client->request('GET', 'https://newsapi.org/v2/top-headlines', [
       'query' => [
           'country' => $country,
           'apiKey' => $apiKey,
           'category'=> $category

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
