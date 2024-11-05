@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">新規作成</h1>
        <div class="detail">
            <form method="post" action="{{ route('forum.store') }}" class="formlist" enctype="multipart/form-data">
                @csrf
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-title" class="text size-mini block">
                                    タイトル
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="title" id="input-title" size="40" required>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="text1" class="text size-mini block">タグ</label>
                                <div class="text size-middle block">
                                    <select type="text" id="input-tag" name="input-tag">
                                        <option value="">選択してください</option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="tagbox" id="tag-list"></div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <span class="inputset">
                                <label for="content" class="text size-mini block">
                                    内容
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <span class="text size-middle block">
                                    <textarea id="content" name="content" rows="10" cols="60" required></textarea>
                                </span>
                            </span>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-video" class="text size-mini block">
                                    添付画像
                                </label>
                                <div class="text size-middle block">
                                    <input type="file" name="images[]" id="input-forums-img" multiple="multiple">
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

@section('js-footer')
    <script src="{{ asset('js/tag.js?v=') . filemtime(public_path('js/tag.js')) }}"></script>
@endsection
