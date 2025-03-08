<?php

namespace App\Interfaces;

interface IFetchArticles
{
  public function fetch($country);
  public function map($articles);
}