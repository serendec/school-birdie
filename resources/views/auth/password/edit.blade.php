@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <div class="detail">
            <form method="post" action="{{ route('user-password.update') }}" class="formlist">
                @csrf
                @method('PUT')
                <div class="detail-content">
                    <div class="detail-content-header">パスワード</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item mode-horizontal">
                            <div class="inputset">
                                <label for="input-current_password" class="text size-mini block">
                                    現在のパスワード
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="password" name="current_password" id="input-current_password" size="30" required>
                                </div>
                            </div>
                        </div>

                        <div class="detail-content-body-item mode-horizontal">
                            <div class="inputset">
                                <label for="input-password" class="text size-mini block">
                                    新しいパスワード
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="password" name="password" id="input-password" size="30" required>
                                </div>
                                <div class="text size-mini block">英数字を含む半角8文字以上</div>
                            </div>
                        </div>

                        <div class="detail-content-body-item mode-horizontal">
                            <div class="inputset">
                                <label for="input-password_confirmation" class="text size-mini block">
                                    新しいパスワード（確認）
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="password" name="password_confirmation" id="input-password_confirmation" size="30" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <button type="submit" class="button button-primary">
                            <span class="text">保存</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
