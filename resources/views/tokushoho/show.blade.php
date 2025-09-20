@extends('layouts.app')

@section('content')
<div class="tokushoho-container">
    <div class="tokushoho-content">
        <h1>特定商取引法に基づく表記</h1>
        <ul class="tokushoho-list">
            <li>
                <strong>販売事業所:</strong>
                {{ $tokushohoData['company_name'] }}
            </li>
            <li>
                <strong>所在地:</strong>
                {{ $tokushohoData['address'] }}
            </li>
            <li>
                <strong>電話番号:</strong>
                {{ $tokushohoData['tel'] }}
                @if(Auth::user()->school->tel_available_time)
                    <br>受付時間：{{ Auth::user()->school->tel_available_time }}
                @endif
            </li>
            <li>
                <strong>メールアドレス:</strong>
                <a href="mailto:{{ $tokushohoData['email'] }}">{{ $tokushohoData['email'] }}</a>
            </li>
            <li>
                <strong>運営統括責任者:</strong>
                {{ $tokushohoData['representative'] }}
            </li>
            <li>
                <strong>追加手数料等の追加料金:</strong>
                {{ $tokushohoData['additional_fees'] }}
            </li>
            <li>
                <strong>返金ポリシー:</strong>
                {{ $tokushohoData['refund_policy'] }}
            </li>
            <li>
                <strong>引渡時期:</strong>
                {{ $tokushohoData['delivery_time'] }}
            </li>
            <li>
                <strong>お支払い方法:</strong>
                {{ $tokushohoData['payment_method'] }}
            </li>
            <li>
                <strong>決済期間:</strong>
                {{ $tokushohoData['payment_period'] }}
            </li>
            <li>
                <strong>販売価格:</strong>
                {{ $tokushohoData['price'] }}
            </li>
            <li>
                <strong>お申込み有効期限:</strong>
                {{ $tokushohoData['validity_period'] }}
            </li>
            <li>
                <strong>販売数量:</strong>
                {{ $tokushohoData['sales_quantity'] }}
            </li>
            <li>
                <strong>ご利用方法:</strong>
                {{ $tokushohoData['usage_method'] }}
            </li>
        </ul>
    </div>
</div>
@endsection

@section('css')
<style>
    .tokushoho-container {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .tokushoho-content {
        max-width: 600px;
        width: 90%;
        margin: 20px auto;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .tokushoho-content h1 {
        font-size: 1.5em;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .tokushoho-list {
        list-style-type: none;
        padding: 0;
    }

    .tokushoho-list li {
        margin-bottom: 15px;
    }

    .tokushoho-list strong {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .tokushoho-list a {
        color: #007bff;
        text-decoration: none;
    }

    .tokushoho-list a:hover {
        text-decoration: underline;
    }
</style>
@endsection
