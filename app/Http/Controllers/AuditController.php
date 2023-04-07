<?php

namespace App\Http\Controllers;


use App\Models\Inventory;
use App\Models\InventoryAudit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $limit = 50;
        $page = $request->query('page', 1);
        $offset = ($page - 1) * $limit;

        $audits = InventoryAudit::orderBy('created_at', 'desc')->skip($offset)->take($limit)->get();

        return view('audit', compact('audits', 'limit', 'page'));
    }
}
