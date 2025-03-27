@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">ダウンロード</h1>
        <div class="detail">
            <form method="post" action="{{ route('student.csv') }}" class="formlist">
                @csrf
                @method('POST')
                <div class="detail-content">
                    <div class="detail-content-header">生徒</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <div class="text size-middle block">
                                    <ul class="check-list">
                                        <li>
                                            <input id="student_name" name="student[]" type="checkbox" checked disabled value="name" >
                                            <label for="student_name">受講者名</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-content">
                    <div class="detail-content-header">受講コース</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <div class="text size-middle block">
                                    <ul class="check-list">
                                        <li>
                                            <input id="course_name" name="course[]" type="checkbox" value="course_name">
                                            <label for="course_name">受講研修名</label>
                                        </li>
                                        <li>
                                            <input id="started_date" name="course[]" type="checkbox" value="started_date">
                                            <label for="started_date">視聴開始日時</label>
                                        </li>
                                        <li>
                                            <input id="finished_date" name="course[]" type="checkbox" value="finished_date">
                                            <label for="finished_date">視聴終了日時</label>
                                        </li>
                                        <li>
                                            <input id="played_count" name="course[]" type="checkbox" value="played_count">
                                            <label for="played_count">進捗ステータス</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <button type="submit" class="button button-primary">
                            <span class="text">ダウンロード</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js-footer')
    <script src="{{ asset('js/user.js') }}?v={{ filemtime(public_path() . '/js/user.js') }}" defer></script>
@endsection
