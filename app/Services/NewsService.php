<?php

namespace App\Services;

use App\Enums\Provider;

class NewsService
{
  public function fetchAll($country)
  {
    $articles = [];
    foreach (Provider::values() as $provider) {
      $service_name = 'App\Services\\' . $provider . 'Service';
      $service = new $service_name();
      $service_articles = $service->fetch($country);
      array_push($articles, ...$service_articles);
    }

    return $articles;
  }
}