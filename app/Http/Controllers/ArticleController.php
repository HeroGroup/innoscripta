<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
      $query = $request->query();
      $articles = DB::table('articles')->whereNotNull('provider');

      $search = array_key_exists('search', $query) ? $query['search'] : '';
      $articles = $articles->when($search, function (Builder $queryBuilder, string $search) {
        $queryBuilder->where('title', 'LIKE', '%'.$search.'%')
          ->orWhere('content', 'LIKE', '%'.$search.'%')
          ->orWhere('source', 'LIKE', '%'.$search.'%')
          ->orWhere('author', 'LIKE', '%'.$search.'%')
          ->orWhere('description', 'LIKE', '%'.$search.'%');
        });

      $articles = $articles->paginate(20);
      return response()->json(['status' => 1, 'data' => $articles]);
    }
}
