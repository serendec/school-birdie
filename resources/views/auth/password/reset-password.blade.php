@extends('layouts.login')

@section('content')
    @if (count($errors) > 0)
        <div class="infomessage type--error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h1 class="screen-heading">パスワード再設定</h1>
    <section class="flat-content">
        <form method="post" action="{{ route('password.update') }}" class="form">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-mail">メールアドレス</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input id="input-mail" type="text" name="email" value="{{ request()->email ?? old('email') }}" required autocomplete="email">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-password">パスワード</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input id="input-password" type="password" name="password" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-password_confirmation">パスワード再入力</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input id="input-password_confirmation" type="password" name="password_confirmation" required>
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
                            <button type="submit" class="button type--first">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
