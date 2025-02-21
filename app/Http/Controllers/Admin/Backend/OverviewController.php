<?php

namespace App\Http\Controllers\Admin\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverviewController extends Controller
{
    public function getData(Request $request)
    {
        $startOfMonth = date("Y-m-01", strtotime($request->month));
        $nextMonth = date("Y-m-d", strtotime("+1 month", strtotime($startOfMonth)));
        $data = DB::table('orders')
            ->selectRaw('DATE(created_at) as order_date, COUNT(id) as total_orders, SUM(total) as total_revenue')
            ->where('created_at','>=',$startOfMonth)
            ->where('created_at','<', $nextMonth)
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get();

        $sortedData = [
            'date' => [],
            'orders' => [],
            'revenue' => []
        ];
        foreach ($data as $key => $value) {
            array_push($sortedData['date'],$value->order_date);
            array_push($sortedData['orders'],$value->total_orders);
            array_push($sortedData['revenue'],$value->total_revenue);
        }
        return response()->json($sortedData, 200);
    }
}
