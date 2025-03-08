<?php

namespace App\Services;

use App\Enums\Provider;
use App\Interfaces\IFetchArticles;
use GuzzleHttp\Client;

class GuardianService implements IFetchArticles
{
  public function __construct()
  {
    $this->base_url = 'https://content.guardianapis.com/search?api-key=' . env('GUARDIAN_API_KEY');
    $this->client = new Client();
  }

  public function fetch($country)
  {
    $query = '&query=' . $country;
    $url = $this->base_url . $query;

    $headers = [ 'Accept' => 'application/json' ];
    $content = $this->client->request('GET', $url, [ 'headers' => $headers ]);
    $content_json = json_decode($content->getBody()?->getContents());

    if ($content_json && $content_json->response && $content_json->response->status == 'ok') {
      return $this->map($content_json->response->results);
    } else {
      return [];
    }
  }

  public function map($articles): array
  {
    return array_map(fn ($article) => [
      'provider' => Provider::Guardian,
      'provider_article_id' => $article->id,
      'source' => null,
      'author' => null,
      'title' => $article->webTitle,
      'description' => null,
      'url' => $article->webUrl,
      'published_at' => $article->webPublicationDate,
      'content' => null
    ], $articles);
  }
}