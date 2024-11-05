@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">新規作成</h1>
        <div class="detail">
            <form method="post" action="{{ route('course_category.store') }}" class="formlist">
                @csrf
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item ma-0">
                            <div class="inputset">
                                <label for="input-name" class="text size-mini block">
                                    カテゴリ名
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="name" id="input-name" value="{{ old('name') }}" size="40" required>
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
