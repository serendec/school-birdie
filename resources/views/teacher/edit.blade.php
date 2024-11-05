@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">編集</h1>
        <div class="detail">
            <form method="post" action="{{ route('teacher.update') }}" class="formlist" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="detail-content">
                    <div class="detail-content-header">アイコンと名前</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="icon" class="text size-mini block">
                                    アイコン
                                </label>
                                <div class="text size-middle block">
                                    <span class="namebox">
                                        @include('partials.icon', [
                                            'icon' => $teacher->icon,
                                            'size' => 'default',
                                            'id'   => 'icon-select'
                                        ])
                                        <span class="text size-default">
                                            <span class="button button-secondary" id="button-select_file">
                                                <span class="text">ファイル選択</span>
                                            </span>
                                            <input type="file" name="icon" id="icon" accept=".png, .jpg" hidden>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item mode-horizontal">
                            <div class="inputset">
                                <label for="input-family_name" class="text size-mini block">
                                    姓
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="family_name" id="input-family_name"
                                        value="{{ $teacher->family_name }}" size="20" required>
                                </div>
                            </div>
                            <div class="inputset">
                                <label for="input-first_name" class="text size-mini block">
                                    名
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="first_name" id="input-first_name"
                                        value="{{ $teacher->first_name }}" size="20" required>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item mode-horizontal">
                            <div class="inputset">
                                <label for="input-family_name_kana" class="text size-mini block">
                                    姓（よみがな）
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="family_name_kana" id="input-family_name_kana"
                                        value="{{ $teacher->family_name_kana }}" size="20" required>
                                </div>
                            </div>
                            <div class="inputset">
                                <label for="input-first_name_kana" class="text size-mini block">
                                    名（よみがな）
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="first_name_kana" id="input-first_name_kana"
                                        value="{{ $teacher->first_name_kana }}" size="20" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-content">
                    <div class="detail-content-header">連絡先</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tel" class="text size-mini block">
                                    電話番号
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="tel" id="input-tel" value="{{ $teacher->tel }}"
                                        size="40" required>
                                </div>
                                <div class="text size-mini block">ハイフンなし（例：09012345678）</div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-email" class="text size-mini block">
                                    メール
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="email" id="input-email" value="{{ $teacher->email }}"
                                        size="40" required>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-line_id" class="text size-mini block">
                                    LINE ID
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="line_id" id="input-line_id"
                                        value="{{ $teacher->line_id }}" size="40">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @can('isAdmin')
                    <div class="detail-content">
                        <div class="detail-content-header">その他</div>
                        <div class="detail-content-body">
                            <div class="detail-content-body-item">
                                <div class="inputset">
                                    <label for="input-plan" class="text size-mini block">
                                        管理者権限
                                    </label>
                                    <div>
                                        <label class="text size-middle mode-button">
                                            <input type="radio" name="role" value="teacher" {{ ($teacher->role == 'teacher' ? 'checked' : '') }}/>なし
                                        </label>
                                        <label class="text size-middle mode-button">
                                            <input type="radio" name="role" value="admin" {{ ($teacher->role == 'admin' ? 'checked' : '') }}/>あり
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                <hr />

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <input type="hidden" name="id" value="{{ $teacher->id }}">
                        <button type="submit" class="button button-primary">
                            <span class="text">保存</span>
                        </button>
                    </div>
                    @can('isAdmin')
                        <div class="edit-footer-right">
                            <button type="button" id="delete-btn" class="button button-thirdly type-alert">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                                <span class="text size-small">削除</span>
                            </button>
                        </div>
                    @endcan
                </div>
            </form>

            <form id="delete-form" action="{{ route('teacher.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $teacher->id }}">
            </form>
        </div>
    </div>
@endsection

@section('js-footer')
    <script src="{{ asset('js/user.js') }}" defer></script>
@endsection
