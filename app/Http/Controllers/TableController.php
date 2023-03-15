<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\Article;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TableController extends Controller
{
//    public function index()
//    {
//        $tables = Table::all();
//
//        return view('tables', [
//            'tables' => $tables,
//        ]);
//    }

//    public function show($id)
//    {
//        $table = Table::find($id);
//
//        if (!$table) {
//            return response()->view('errors.404', [], 404);
//        }
//
//        return view('table', [
//            'table' => $table,
//        ]);
//    }
    public function showTable($id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->view('errors.404', [], 404);
        }

        $articleTypes = Article::distinct()->pluck('type');
        $articles = Article::query();

        if ($type = request('type')) {
            $articles->where('type', $type);
        }

        $articles = $articles->get();

        return view('table', [
            'table' => $table,
            'articleTypes' => $articleTypes,
            'articles' => $articles,
            'type' => $type,
        ]);
    }

//    public function showTable($id)
//    {
//        $table = Table::find($id);
//
//        if (!$table) {
//            return response()->view('errors.404', [], 404);
//        }
//
//        $articles = Article::all();
//        $type = request('type');
//        if ($type) {
//            $articles = (new Article())->scopeOfType($type)->get();
//
//        }
//
//        return view('table', [
//            'table' => $table,
//            'articles' => $articles,
//            'type' => $type,
//        ]);
//    }

//    public function placeOrder(Request $request, $table_id)
//    {
//        $this->validate($request, [
//            'article_id' => 'required|exists:articles,id',
//            'quantity' => 'required|integer|min:1',
//        ]);
//
//        $user = Auth::user();
//        $table = Table::findOrFail($table_id);
//
//        $order = $user->orders()->create([
//            'table_id' => $table_id,
//            'finalized_at' => null,
//        ]);
//
//        $article_id = $request->input('article_id');
//        $quantity = $request->input('quantity');
//        $order->articles()->attach($article_id, ['quantity' => $quantity]);
//
//        return response()->json([
//            'success' => true,
//            'order' => $order,
//        ]);
//    }
}
