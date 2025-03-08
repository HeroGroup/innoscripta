<?php

namespace App\Services;

use App\Enums\Provider;
use App\Interfaces\IFetchArticles;
use NewsdataIO\NewsdataApi;

class NewsDataIOService implements IFetchArticles
{
  public function __construct()
  {
    $this->newsdataApi = new NewsdataApi(env('NEWS_DATA_IO_API_KEY'));
  }

  public function fetch($country): array
  {
    $data = array("country" => $country);
    $response = $this->newsdataApi->get_latest_news($data);

    if ($response && $response->status == "success" && count($response->results) > 0) {
      return $this->map($response->results);
    } else {
      return [];
    }
  }

  public function map($articles): array
  {
    // map fields to columns
    return array_map(fn ($article) => [
      'provider' => Provider::NewsDataIO,
      'provider_article_id' => $article->article_id,
      'source' => $article->source_id,
      'author' => $article->creator[0] ?? null,
      'title' => $article->title,
      'description' => $article->description,
      'url' => $article->link,
      'published_at' => $article->pubDate,
      'content' => null
    ], $articles);
  }
}