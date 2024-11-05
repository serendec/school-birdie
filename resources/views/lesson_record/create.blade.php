@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">記録を作成</h1>
        <div class="detail">
            <form method="post" action="{{ route('lesson_record.store') }}" class="formlist" enctype="multipart/form-data">
                @csrf
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-lesson-date" class="text size-mini block">レッスン実施日
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="date" name="lesson_date" id="input-lesson-date" value="{{ old('lesson_date') ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="select-student" class="text size-mini block">生徒
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <select id="select-student" name="student_id" required>
                                        <option value="">選択してください</option>
                                        @foreach ($studentsList as $student)
                                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                                {{ $student->family_name }} {{ $student->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text size-mini block" id="history_link"></div>
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
                                    @if (!empty($lessonRecord->tags))
                                        @foreach ($lessonRecord->tags as $selectedTag)
                                            <span class="tag">
                                                {{ $selectedTag->name }}
                                                <button type="button" class="material-symbols-outlined">close</button>
                                                <input type="hidden" name="tag_ids[]" value="{{ $selectedTag->id }}">
                                            </span>
                                        @endforeach
                                    @endif
                                    @if (old('tag_ids'))
                                        @foreach (old('tag_ids') as $tagId)
                                            <span class="tag">
                                                {{ $tagsKeyId[$tagId] }}
                                                <button type="button" class="material-symbols-outlined">close</button>
                                                <input type="hidden" name="tag_ids[]" value="{{ $tag->id }}">
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-video" class="text size-mini block">動画
                                </label>
                                <div class="text size-middle block">
                                    <input type="file" name="video[]" id="input-movie" accept="video/*" multiple>
                                </div>
                                <div class="text size-mini block">動画ファイルは最大10個（合計2GB）までアップロードできます。</div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-title" class="text size-mini block">タイトル
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="title" id="input-title" size="40" value="{{ old('title') ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <span class="inputset">
                                <label for="summary" class="text size-mini block">レッスン概要</label>
                                <span class="text size-middle block">
                                    <textarea id="summary" name="summary" rows="5" cols="60">{{ old('summary') ?? '' }}</textarea>
                                </span>
                            </span>
                        </div>
                        <div class="detail-content-body-item">
                            <span class="inputset">
                                <label for="teacher_comment" class="text size-mini block">生徒へのコメント</label>
                                <span class="text size-middle block">
                                    <textarea id="teacher_comment" name="teacher_comment" rows="5" cols="60">{{ old('teacher_comment') ?? '' }}</textarea>
                                </span>
                            </span>
                        </div>
                        <div class="detail-content-body-item">
                            <span class="inputset">
                                <label for="school_memo" class="text size-mini block">スクール内メモ</label>
                                <span class="text size-middle block">
                                    <textarea id="school_memo" name="school_memo" rows="5" cols="60">{{ old('school_memo') ?? '' }}</textarea>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <input type="hidden" name="teacher_id" value="{{ Auth::user()->id }}">
                        <button type="submit" name="post_status" value="draft" class="button button-primary">
                            <span class="text">下書き保存</span>
                        </button>
                        <button type="submit" name="post_status" value="publish" class="button button-secondary">
                            <span class="text">公開</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('partials.modal')
@endsection

@section('js-footer')
    <script src="{{ asset('js/tag.js?v=') . filemtime(public_path('js/tag.js')) }}"></script>
@endsection
