<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index($business_name)
    {
        $business_name = base64_decode($business_name);
        return view('reports', compact('business_name'));
    }
    public function reportList(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $business_name = $request->business_name;

        $query = DB::table('vw_restaurants');

        if($start_date && $end_date && $business_name){
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            $query->whereBetween('transaction_date',[$start_date,$end_date]);
            $query->where('business_name',$business_name);
            $query->select('business_name','business_zone','transaction_date','invoice_no','total_before_tax','tax_amount','final_amount','cash','card','coupon','tips');
            return datatables()->of($query)
                ->make(true);
        }
        return [];
    }
}
