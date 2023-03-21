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

        $validator = Validator::make($request->all(), [
            'apiKey' => 'required|string',
            'country' => 'sometimes|string',
             'sources' => 'sometimes|string',
            // 'category' => 'sometimes|string',
             'q' => 'sometimes|string',
            // 'pageSize' => 'sometimes|integer|max:100',
            // 'page' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $client = new Client();
         $apiKey = $request->input('2b5c5c3ce4c248dab3f726ebe8d0ac7c');
         $category = $request->input('category', 'general');
        $language = $request->input('language', 'en');
        $response = $client->request('GET', 'https://newsapi.org/v2/everything', [
            'query' => [
                'apiKey' => $apiKey,
                'category' => $category,
                'language' => $language,

                // 'apiKey' => $request->input('apiKey'),
                // 'country' => $request->input('country'),
                // 'sources' => $request->input('sources'),
                // 'category' => $request->input('category'),
                 'q' => $request->input('q'),
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


}
