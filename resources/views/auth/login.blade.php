@extends('layouts.login')

@section('content')
    @if (session('status'))
        <div class="infomessage type--success">
            <p>{{ session('status') }}</p>
        </div>
    @endif
    @error('email')
        <div class="infomessage type--error">
            <p>{{ $message }}</p>
        </div>
    @enderror

    <div class="login-content-inner">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="inputset wfull">
                <label for="input-email">メールアドレス</label>
                <div class="with-notes notes-bottom">
                    <input type="text" id="input-email" name="email" class="wfull @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus />
                </div>
            </div>
            <div class="inputset wfull">
                <label for="input-password">パスワード</label>
                <div class="with-notes notes-bottom">
                    <input type="password" id="input-password" name="password" class="wfull @error('password') is-invalid @enderror" />
                </div>
            </div>
            <button type="submit" class="button type--first">ログイン</button>
            <a href="{{ route('password.email') }}" class="button type--second">パスワードを忘れた方はこちら</a>
        </form>
    </div>
@endsection
