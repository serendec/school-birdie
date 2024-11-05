@extends('layouts.login')

@section('content')
    @if (session('status') == 'verification-link-sent')
        <div class="infomessage type--error">
            <p>あなたのメールアドレスに認証用のメールを再送信しました。</p>
        </div>
    @endif
    
    <h1 class="screen-heading">メールアドレスの認証</h1>
    <section class="flat-content">
        認証用リンクをご入力のメールアドレスに送信しましたので、メールをご確認ください。
        もし認証用のメールを受信されていない場合は、再送信ボタンをクリックしてください。
        <form class="form" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="formlist-line">
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="button-container">
                            <button type="submit" class="button type--first">再送信</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
