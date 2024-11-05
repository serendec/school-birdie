@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">お問い合わせ</h1>
        <div class="detail">
            <form method="post" action="{{ route('contact.store') }}" class="formlist">
                @csrf
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item ma-0">
                            <div class="inputset">
                                <label for="input-content" class="text size-mini block">
                                    内容
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <textarea id="input-content" name="content" rows="5" cols="60"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <button type="submit" class="button button-primary">
                            <span class="text">送信</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
