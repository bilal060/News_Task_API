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
    //  $apiKey = $request->input('b2a64c534fff42809aaa65f271409db9');
    //     $validator = Validator::make($request->all(), [
    //         'apiKey' => 'required|string',
    //         'country' => 'sometimes|string',
    //         //  'sources' => 'sometimes|string',
    //         // // 'category' => 'sometimes|string',
    //         //  'q' => 'sometimes|string',
    //         // // 'pageSize' => 'sometimes|integer|max:100',
    //         // // 'page' => 'sometimes|integer',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 400);
    //     }

        $client = new Client();
         $apiKey = $request->input('apiKey','b2a64c534fff42809aaa65f271409db9');
         $category = $request->input('category', 'general');
         $country = $request->input('country', 'us');
        $language = $request->input('language', 'en');
        $response = $client->request('GET', 'https://newsapi.org/v2/top-headlines', [
            'query' => [
                'country' => $country,
                'apiKey' => $apiKey,
                'category' => $request->input('category'),
                // 'language' => $language,
                // 'apiKey' => $request->input('apiKey'),
                // 'country' => $request->input('country'),
                // 'sources' => $request->input('sources'),

                //  'q' => $request->input('q'),
                // 'pageSize' => $request->input('pageSize'),
                // 'page' => $request->input('page'),
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        return response()->json([
            'status' => 'ok',
            'totalResults' => $data['totalResults'],
            'articles' => $data['articles'],
        ]);

        // $newsApiKey = '2b5c5c3ce4c248dab3f726ebe8d0ac7c';
        // $openNewsApiKey = 'YOUR_OPENNEWSAPI_KEY';
        // $url = 'https://newsapi.org/v2/top-headlines?country=us&apiKey=' . $newsApiKey;
        // // $openNewsUrl = 'https://opennewsapi.com/api/v1/news?api_key=' . $openNewsApiKey;

        // $response = Http::get($url);
        // // $openNewsResponse = Http::get($openNewsUrl);

        // $data = [
        //     'newsapi' => $response->json(),
        //     // 'opennewsapi' => $openNewsResponse->json()
        // ];

        // return response()->json($data);
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


