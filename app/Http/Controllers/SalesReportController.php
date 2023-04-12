<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ArticleOrder;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index()
    {
        return view('sales-report');
    }
    public function getSalesReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // If start and end dates are not provided, default to today and yesterday
        if (!$startDate && !$endDate) {
            $startDate = Carbon::now()->subDay()->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
        }

        // Query the database for the sales report for the selected date range
        $salesReportData = ArticleOrder::select(DB::raw('article_name, SUM(quantity) as total_quantity, SUM(quantity * price) as total_sales'))
            ->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->groupBy('article_name')
            ->orderBy('total_sales', 'DESC')
            ->get();



        // Pass the sales report data to a view to display the results
        return view('sales-report-results', compact('salesReportData', 'startDate', 'endDate'));
    }
}
