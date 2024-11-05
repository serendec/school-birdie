@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">講師登録用QRコード</h1>
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <p>講師の方はQRコードを読み取るか、URLにアクセスして下さい。</p>
                        <p><a href="{{ url('/register/?token='.$schoolToken) }}" class="break-word" target="_blank">{{ url('/register/?token='.$schoolToken) }}</a></p>
                        <p>
                            {!! QrCode::generate(url('/register/?token='.$schoolToken)) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
