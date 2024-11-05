@extends('layouts.login')

@section('content')
    @if (session('status'))
        <div class="infomessage type--success">
            <p>{{ session('status') }}</p>
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="infomessage type--error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h1 class="screen-heading">パスワード再設定</h1>
    <p>ご登録のメールアドレスを入力してください。<br />パスワード再設定用のメールをお送りします。</p>
    <section class="flat-content">
        <form method="POST" action="{{ route('password.email') }}" class="form">
            @csrf
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-mail">メールアドレス</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input id="input-mail" type="text" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-teacher-memo">　</label>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="button-container">
                            <button type="submit" class="button type--first">送信</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
