<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orderCounts = Transaction::where('transaction_type', 'order')
        ->groupBy('order_status')
        ->select('order_status as status',DB::raw('COUNT(*) as order_count'))
        ->get();
        return view('home', compact('orderCounts'));
    }
}
