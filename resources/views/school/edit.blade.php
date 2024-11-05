@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">編集</h1>
        <div class="detail">
            <form method="post" action="{{ route('school.update') }}" class="formlist" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="detail-content">
                    <div class="detail-content-header">名称</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-name" class="text size-mini block">
                                    スクール名
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="name" id="input-name" value="{{ old('name', $school->name) }}" size="40" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-content">
                    <div class="detail-content-header">概要</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-url" class="text size-mini block">
                                    公式ホームページURL
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-url" name="url" value="{{ $school->url }}" size="40" />
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tel" class="text size-mini block">
                                    お問い合わせ先電話番号
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-tel" name="tel" value="{{ $school->tel }}" size="13" />
                                </div>
                                <div class="text size-mini block">ハイフンなし（例：0312345678）</div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tel_available_time" class="text size-mini block">
                                    電話受付時間
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="tel_available_time" id="input-tel_available_time" value="{{ $school->tel_available_time }}" size="40">
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-email" class="text size-mini block">
                                    お問い合わせ先メールアドレス
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-email" name="email" value="{{ $school->email }}" size="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-content">
                    <div class="detail-content-header">画像</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="icon" class="text size-mini block">
                                    アイコン
                                </label>
                                <div class="text size-middle block">
                                    <span class="namebox">
                                        @include('partials.icon', [
                                            'icon' => $school->icon,
                                            'size' => 'default',
                                            'id'   => 'icon-select'
                                        ])
                                        <span class="text size-default">
                                            <span class="button button-secondary" id="button-select_file">
                                                <span class="text">ファイル選択</span>
                                            </span>
                                            <input type="file" name="icon" id="icon" accept=".png,.jpg,.jpeg" hidden>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-file" class="text size-mini block">
                                    トップ画面背景
                                </label>
                                <div class="text size-middle block">
                                    <span class="namebox">
                                        @php
                                            $img_path = ($school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . $school->top_img : '/storage/img/default-top.jpg';
                                        @endphp
                                        <span class="avator size-default" style="background-image:url('{{ $img_path }}');border-radius:0;" id="selected_top_img"></span>
                                        <span class="text size-default mr-8">
                                            <span class="button button-secondary" id="button-select_img_file">
                                                <span class="text">ファイル選択</span>
                                            </span>
                                            <input type="file" name="top_img" id="input-file" accept=".png,.jpg,.jpeg" hidden>
                                        </span>
                                        <label><input type="checkbox" name="clear_top_img" value="1">初期化</label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

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

@section('js-footer')
    <script src="{{ asset('js/user.js') }}" defer></script>
@endsection
