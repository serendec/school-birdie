@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">生徒登録用QRコード</h1>
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <p>生徒の方はQRコードを読み取るか、URLにアクセスして下さい。</p>
                        <p><a href="{{ url('/register/?token='.$studentToken) }}" target="_blank" class="break-word">{{ url('/register/?token='.$studentToken) }}</a></p>
                        <p>
                            {!! QrCode::generate(url('/register/?token='.$studentToken)) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
