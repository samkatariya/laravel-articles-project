<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index');
    }

    public function fetchArticles(Request $request)
    {
        // Create a Guzzle client
        $client = new Client();
        $response = $client->get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');
        
        // Decode the JSON response
        $data = json_decode($response->getBody()->getContents(), true);
        
        // Check the structure of the data
        if (!isset($data['item'])) {
            return response()->json([
                'data' => [],
                'total' => 0,
                'per_page' => 10,
                'current_page' => $request->input('page', 1),
            ]);
        }

        $articles = $data['item'];

        // Implement searching, sorting, and pagination
        $query = $request->input('query');
        $sortBy = $request->input('sortBy', 'pubDate');
        $sortDirection = $request->input('sortDirection', 'desc');
        $perPage = $request->input('perPage', 10);

        if ($query) {
            $articles = array_filter($articles, function ($article) use ($query) {
                return stripos($article['title'], $query) !== false;
            });
        }

        usort($articles, function ($a, $b) use ($sortBy, $sortDirection) {
            if ($sortDirection === 'asc') {
                return strcmp($a[$sortBy], $b[$sortBy]);
            } else {
                return strcmp($b[$sortBy], $a[$sortBy]);
            }
        });

        $total = count($articles);
        $articles = array_slice($articles, ($request->input('page', 1) - 1) * $perPage, $perPage);

        return response()->json([
            'data' => $articles,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $request->input('page', 1),
        ]);
    }
}
