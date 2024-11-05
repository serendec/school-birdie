@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">編集</h1>
        <div class="detail">
            <form method="post" action="{{ route('video_advice.update') }}" class="formlist" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-title" class="text size-mini block">
                                    添削依頼タイトル
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="title" id="input-title"
                                        value="{{ $videoAdvice->title }}" size="40" required>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-video" class="text size-mini block">
                                    動画
                                </label>
                                <div class="text size-middle block">
                                    <input type="file" name="video[]" id="input-video" accept="video/*" multiple>
                                </div>
                                <div class="text size-mini block">
                                    動画ファイルは最大10個（合計2GB）までアップロードできます。<br>新しい動画を選択しない場合、以前に登録された動画が引き続き使用されます。
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <span class="inputset">
                                <label for="question" class="text size-mini block">
                                    質問内容
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <span class="text size-middle block">
                                    <textarea id="question" name="question" rows="5" cols="60" required>{{ $videoAdvice->question }}</textarea>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <input type="hidden" name="id" value="{{ $videoAdvice->id }}">
                        <button type="submit" class="button button-primary">
                            <span class="text">保存</span>
                        </button>
                    </div>
                    @if ($videoAdvice->comments->isEmpty())
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

            <form id="delete-form" action="{{ route('video_advice.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $videoAdvice->id }}">
            </form>
        </div>
    </div>

    @include('partials.modal')
@endsection
