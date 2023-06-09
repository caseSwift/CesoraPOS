<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index($type)
    {
        $articles = Article::where('type', $type)->get();
        return view('articles.index', compact('articles'));
    }
}
