<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

class TokushohoController extends Controller
{
    /**
     * 特商法ページを表示
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $school = Auth::user()->school;

        // 特商法情報は入力された項目のみ表示するため、デフォルト値は設定しない
        $tokushohoData = [
            'company_name' => $school->tokushoho_company_name,
            'address' => $school->tokushoho_address,
            'tel' => $school->tokushoho_tel,
            'email' => $school->tokushoho_email,
            'representative' => $school->tokushoho_representative,
            'additional_fees' => $school->tokushoho_additional_fees,
            'refund_policy' => $school->tokushoho_refund_policy,
            'delivery_time' => $school->tokushoho_delivery_time,
            'payment_method' => $school->tokushoho_payment_method,
            'payment_period' => $school->tokushoho_payment_period,
            'price' => $school->tokushoho_price,
            'validity_period' => $school->tokushoho_validity_period,
            'sales_quantity' => $school->tokushoho_sales_quantity,
            'usage_method' => $school->tokushoho_usage_method,
        ];

        return view('tokushoho.show', compact('tokushohoData'));
    }
}
