@extends('layouts.app')

@section('js')
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce_api_key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">新規作成</h1>
        <div class="detail">
            <form method="post" action="{{ route('course.store') }}" class="formlist" enctype="multipart/form-data">
                @csrf
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-title" class="text size-mini block">
                                    講座名
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
                                <label for="input-title" class="text size-mini block">
                                    講座カテゴリ
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <select id="input-category_id" name="category_id" required>
                                        <option value="">選択してください</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-video" class="text size-mini block">
                                    動画
                                </label>
                                <div class="text size-middle block">
                                    <input type="file" name="video" id="input-video" accept="video/*">
                                </div>
                                <div class="text size-mini block">動画ファイルは最大2GBまでアップロードできます。</div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <span class="inputset">
                                <label for="question" class="text size-mini block">
                                    説明
                                </label>
                                <span class="text size-middle block">
                                    <textarea name="content" id="input-lectures-description"></textarea>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <button type="submit" name="post_status" value="publish" class="button button-primary">
                            <span class="text">保存</span>
                        </button>
                        <button type="submit" name="post_status" value="draft" class="button button-primary">
                            <span class="text">下書き保存</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('partials.modal')
@endsection

@section('js-footer')
    <script>
        tinymce.init({
            selector: 'textarea',
            language: 'ja',
            menubar: false,
            branding: false,
            elementpath: false,
            // newline_behavior: 'linebreak',
            height: 500,
            plugins: 'lists link image table',
            toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough forecolor backcolor | numlist bullist | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist indent outdent | emoticons charmap',
            automatic_uploads: false,
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var blobInfo = blobCache.create(id, file, reader.result);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            }
        });
    </script>
@endsection
