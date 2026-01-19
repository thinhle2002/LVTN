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
    public function byCustomer(Request $request)
    {
        $fromDate = $request->get('from_date', date('Y-m-01'));
        $toDate = $request->get('to_date', date('Y-m-d'));
        $search = $request->get('search');

        $revenueData = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('orders.status', Constant::order_status_Finished)
            ->whereBetween('orders.created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.phone', 'like', '%' . $search . '%');
                });
            })
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(order_details.total) as total_revenue'),
                DB::raw('AVG(order_details.total) as avg_order_value')
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.phone')
            ->orderBy('total_revenue', 'DESC')
            ->paginate(10);

        $summary = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', Constant::order_status_Finished)
            ->whereBetween('orders.created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->select(
                DB::raw('COUNT(DISTINCT orders.user_id) as total_customers'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(order_details.total) as total_revenue')
            )
            ->first();

        return view('admin.revenue.by-customer', compact('revenueData', 'summary', 'fromDate', 'toDate', 'search'));
    }
}