<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ReportsController extends Controller
{
    public function customerReports()
    {
        \Session::put('page', 'customer_reports');

        $data = Order::join('users as u', 'u.id', 'orders.user_id')->get();
        $data  = \DB::table('users as u');

        $req = app()->request;
        $addSql = '';
        if ($req->filter == 'transaksi_terbanyak') {
            $data = $data->whereRaw("u.id in(select o.user_id from orders o)")->orderByRaw("1 desc");
        } elseif ($req->filter == 'pelanggan_lama') {
            $addSql = "and DATE(ss.created_at) < DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
            $data = $data->whereRaw("u.id in(select o.user_id from orders o where DATE(o.created_at) < DATE_SUB(CURDATE(), INTERVAL 3 MONTH))")->orderByRaw("1 desc");
        } elseif ($req->filter == 'belanja_terbanyak') {
            $data = $data->orderByRaw("2 desc");
        } else {
            $data =
                $data->whereRaw("u.id in(select o.user_id from orders o)");
        }

        $data = $data
            ->selectRaw("
                (select count(1) from orders s where s.user_id = u.id) total_pembelian,
                (select sum(ss.grand_total) from orders ss where ss.user_id = u.id) total_belanja,
                (select DATE_FORMAT(ss.created_at, '%d-%m-%Y') from orders ss where ss.user_id = u.id $addSql order by ss.id desc limit 1) as tgl_pembelian_trkhr,
                u.*, 
                DATE_FORMAT(u.birthdate, '%d-%m-%Y') birthdate
            ")->limit(5)->get();
        return view('admin.reports.customer_reports', compact('data'));
    }

    public function transactionReports()
    {
        Session::put('page', 'transaction_reports');

        return view('admin.reports.transaction_reports');
    }
}
