<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{

    public function index(Request $request)
    {
        $fromDate = $request->get('from_date', date('Y-m-01'));
        $toDate = $request->get('to_date', date('Y-m-d'));
        $search = $request->get('search');

        $revenueData = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.status', Constant::order_status_Finished)
            ->whereBetween('orders.created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->when($search, function ($query) use ($search) {
                return $query->where('products.name', 'like', '%' . $search . '%');
            })
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                DB::raw('SUM(order_details.qty) as total_quantity'),         
                DB::raw('SUM(order_details.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_revenue', 'DESC')
            ->paginate(10);

        $summary = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', Constant::order_status_Finished)
            ->whereBetween('orders.created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->select(
                DB::raw('SUM(order_details.qty) as total_products'),
                DB::raw('SUM(order_details.total) as total_revenue')
            )
            ->first();

        return view('admin.revenue.index', compact('revenueData', 'summary', 'fromDate', 'toDate', 'search'));
    }
}