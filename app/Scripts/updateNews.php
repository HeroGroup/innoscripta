<?php

use App\Models\Article;
use App\Services\NewsService;

function updateNews($country)
{
  try {
    $news_service = new NewsService();
    $articles = $news_service->fetchAll($country);

    $uniqueArticles = [];
    for ($i=0; $i < count($articles); $i++) { 
        $article = $articles[$i];
        if (!Article::where('provider', $article['provider'])
                ->where('title', $article['title'])
                ->where('url', $article['url'])
                ->where('published_at', $article['published_at'])
                ->first())
        {
            array_push($uniqueArticles, $article);
        }
    }

    Article::insert($uniqueArticles);

    dump( 
        count($uniqueArticles) > 0 ? 
        'New articles inserted successfully!' : 
        'No new articles were found!');
  } catch (\Exception $exception) {
    dump($exception->getMessage());
  }
}