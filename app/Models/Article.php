<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'provider',
        'provider_article_id',
        'source',
        'author',
        'title',
        'description',
        'url',
        'published_at',
    ];
}
