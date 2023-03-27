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

    $full_name = str_replace('_', ' ', $authorName);
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
        if ($article['author'] === $full_name) {
            $filtered_articles[] = $article;
        }

    }
    return response()->json($filtered_articles);

}



public function getAuthor(Request $request)
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
    $articles = $data['articles'];
    $authors = [];
    foreach ($articles as $article) {
        $author = $article['author'];
        if (!empty($author)) {
            $authors[] = $author;
        }
    }

    return response()->json($authors);

}


public function filterByCategoryandAuthor(Request $request, $category ,$authorName)
{
    $full_name = str_replace('_', ' ', $authorName);
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
        if ($article['author'] === $full_name) {
            $filtered_articles[] = $article;
        }

    }
    return response()->json($filtered_articles);

}



public function getAuthorbycategory(Request $request,$category)
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
    $articles = $data['articles'];
    $authors = [];
    foreach ($articles as $article) {
        $author = $article['author'];
        if (!empty($author)) {
            $authors[] = $author;
        }
    }

    return response()->json($authors);

}



public function nytNews(Request $request)
{
    $client = new Client();
     $apiKey = $request->input('api-key','67jOh73QDljMpbwMEE7owqNwLdTESCwZ');
     $country = $request->input('country', 'us');
    $response = $client->request('GET', 'https://api.nytimes.com/svc/mostpopular/v2/emailed/7.json', [
        'query' => [
            'api-key' => $apiKey,
        ]
    ]);
    $data = json_decode($response->getBody()->getContents(), true);
    return response()->json([
        'status' => 'ok',
        'copyright' => $data['copyright'],
        'num_results' => $data['num_results'],
        'results' => $data['results'],
    ]);
}


public function nytNewsbyCategory(Request $request , $category)
{
    $full_name = str_replace('', '.json', $category);

    $client = new Client();
     $apiKey = $request->input('api-key','67jOh73QDljMpbwMEE7owqNwLdTESCwZ');
     $country = $request->input('country', 'us');
     $response = $client->request('GET', 'https://api.nytimes.com/svc/topstories/v2/' . $category . '.json', [
         'query' => [
             'api-key' => $apiKey,
         ]
     ]);
     $articles = json_decode($response->getBody(), true)["results"];

     $multimedia = [];
     foreach ($articles as $article) {
         $articleMultimedia = $article["multimedia"];
         foreach ($articleMultimedia as $media) {
             $multimedia[] = $media["url"];
         }
     }

     return response()->json([
        // 'status' => 'ok',
        // // 'copyright' => $articles['copyright'],
        // 'num_results' => $articles['num_results'],
        //  'articles' => $articles['results'],
        'articles'=>$articles,
         "multimedia" => $multimedia,

     ]);

    // return response()->json([
    //     'status' => 'ok',
    //     'copyright' => $data['copyright'],
    //     'num_results' => $data['num_results'],
    //     'articles' => $data['results'],
    //      'media' => $multimedia
    // ]);
}




public function newsApi(Request $request , $category)
{
    $full_name = str_replace('', '.json', $category);

    $client = new Client();
     $apiKey = $request->input('api-key','67jOh73QDljMpbwMEE7owqNwLdTESCwZ');
     $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->get('http://eventregistry.org/api/v1/article/getArticles', [
        'uri' => '240f6a12-b9d8-40a6-b1c6-a220e31d08de',
        'infoArticleBodyLen' => -1,
        'resultType' => 'articles',
        'articlesSortBy' => 'fq',
        'apiKey' => 'ca75f93c-9412-42bc-a6ec-d789dbd34fbe',
    ]);
    $data = json_decode($response->getBody()->getContents(), true);
    return response()->json([
        $data
    ]);
}
};



