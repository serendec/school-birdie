@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">新規作成</h1>
        <div class="detail">
            <form method="post" action="{{ route('video_advice.store') }}" class="formlist" enctype="multipart/form-data">
                @csrf
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
                                        size="40" required>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-video" class="text size-mini block">
                                    動画
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="file" name="video[]" id="input-video" accept="video/*" multiple required>
                                </div>
                                {{-- <div class="text size-mini block">動画ファイルは1つ30MBまで、最大2つアップロードできます。</div> --}}
                                <div class="text size-mini block">動画ファイルは最大10個（合計2GB）までアップロードできます。</div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <span class="inputset">
                                <label for="question" class="text size-mini block">
                                    質問内容
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <span class="text size-middle block">
                                    <textarea id="question" name="question" rows="5" cols="60" required></textarea>
                                </span>
                            </span>
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

    @include('partials.modal')
@endsection
