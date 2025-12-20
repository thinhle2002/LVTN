<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        
        $vouchers = Voucher::orderBy('start_date', 'desc')->get();
        
        return view('front.vouchers.index', compact('vouchers'));
    }
}
