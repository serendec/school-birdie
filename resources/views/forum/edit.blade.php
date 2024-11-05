@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">編集</h1>
        <div class="detail">
            <form method="post" action="{{ route('forum.update') }}" class="formlist" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-title" class="text size-mini block">
                                    タイトル
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="title" id="input-title"
                                        value="{{ $forum->title }}" size="40" required>
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
                                <div class="tagbox" id="tag-list">
                                    @if (!empty($forum->tags))
                                        @foreach ($forum->tags as $selectedTag)
                                            <span class="tag">
                                                {{ $selectedTag->name }}
                                                <button type="button" class="material-symbols-outlined">close</button>
                                                <input type="hidden" name="tag_ids[]" value="{{ $selectedTag->id }}">
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <span class="inputset">
                                <label for="content" class="text size-mini block">
                                    内容
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <span class="text size-middle block">
                                    <textarea id="content" name="content" rows="10" cols="60" required>{{ $forum->content }}</textarea>
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
                                <div class="text size-mini block">
                                    新しい画像を選択しない場合、以前に登録された画像が引き続き使用されます。
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <input type="hidden" name="id" value="{{ $forum->id }}">
                        <button type="submit" class="button button-primary">
                            <span class="text">保存</span>
                        </button>
                    </div>
                    @if ($forum->comments->isEmpty())
                        <div class="edit-footer-right">
                            <button type="button" id="delete-btn" class="button button-thirdly type-alert">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                                <span class="text size-small">削除</span>
                            </button>
                        </div>
                    @endif
                </div>
            </form>

            <form id="delete-form" action="{{ route('forum.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $forum->id }}">
            </form>
        </div>
    </div>
@endsection

@section('js-footer')
    <script src="{{ asset('js/tag.js?v=') . filemtime(public_path('js/tag.js')) }}"></script>
    <script src="{{ asset('js/forum.js?v=') . filemtime(public_path('js/forum.js')) }}"></script>
    <script>
        $(function() {
            $('#delete-btn').on('click', function() {
                if (confirm('本当に削除しますか？')) {
                    $('#delete-form').submit();
                }
            });
        });
    </script>
@endsection
