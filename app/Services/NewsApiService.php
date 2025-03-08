<?php

namespace App\Services;

use App\Enums\Provider;
use App\Interfaces\IFetchArticles;
use jcobhams\NewsApi\NewsApi;

class NewsApiService implements IFetchArticles
{
  public function __construct()
  {
    $this->newsapi = new NewsApi(env('NEWS_API_KEY'));
  }

  public function fetch($country): array
  {
    // $all_articles = $this->newsapi->getEverything($q, $sources, $domains, $exclude_domains, $from, $to, $language, $sort_by, $page_size, $page);
    $top = $this->newsapi->getTopHeadLines(null, null, $country, null, 10);

    if ($top && $top->status == "ok" && count($top->articles) > 0) {
      return $this->map($top->articles);
    } else {
      return [];
    }
  }

  public function map($articles): array
  {
    // map fields to columns
    return array_map(fn ($article) => [
      'provider' => Provider::NewsApi,
      'provider_article_id' => null,
      'source' => $article->source->name ?? '',
      'author' => $article->author,
      'title' => $article->title,
      'description' => $article->description,
      'url' => $article->url,
      'published_at' => $article->publishedAt,
      'content' => $article->content
    ], $articles);
  }
}