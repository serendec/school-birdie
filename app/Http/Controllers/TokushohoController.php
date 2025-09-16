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
        
        // 特商法情報が未設定の場合はデフォルト値を設定
        $tokushohoData = [
            'company_name' => $school->tokushoho_company_name ?? $school->name,
            'address' => $school->tokushoho_address ?? '',
            'tel' => $school->tokushoho_tel ?? $school->tel,
            'email' => $school->tokushoho_email ?? $school->email,
            'representative' => $school->tokushoho_representative ?? '',
            'additional_fees' => $school->tokushoho_additional_fees ?? 'なし',
            'refund_policy' => $school->tokushoho_refund_policy ?? 'いかなる場合においても実施後の返金はできませんのでご了承ください。',
            'delivery_time' => $school->tokushoho_delivery_time ?? '注文後すぐにご利用いただけます。',
            'payment_method' => $school->tokushoho_payment_method ?? 'クレジットカード',
            'payment_period' => $school->tokushoho_payment_period ?? 'クレジットカード決済はただちに処理されます。',
            'price' => $school->tokushoho_price ?? '各商品ページをご参照ください。',
            'validity_period' => $school->tokushoho_validity_period ?? '3か月',
            'sales_quantity' => $school->tokushoho_sales_quantity ?? '無制限',
            'usage_method' => $school->tokushoho_usage_method ?? '当方よりご利用案内をお送りいたします。'
        ];

        return view('tokushoho.show', compact('tokushohoData'));
    }
}
