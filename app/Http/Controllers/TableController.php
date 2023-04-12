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

    public function populateTables()
    {
        $startTableId = 2;
        $endTableId = 50;
        $tableName = 'table';
        $startPosition = 2;
        $endPosition = 50;

        $table = new Table();

        for ($i = $startTableId; $i <= $endTableId; $i++) {
            $table->name = $tableName . $i;
            $table->position = $startPosition + $i - $startTableId;
            $table->save();
        }

        return 'Tables have been populated successfully.';
    }

}
