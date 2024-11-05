@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">編集</h1>
        <div class="detail">
            <form method="post" action="{{ route('course_category.update', $category->id) }}" class="formlist">
                @csrf
                @method('PATCH')
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item ma-0">
                            <div class="inputset">
                                <label for="input-name" class="text size-mini block">
                                    カテゴリ名
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="name" id="input-name" value="{{ old('name', $category->name) }}" size="40" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <input type="hidden" name="id" value="{{ $category->id }}">
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

            <form id="delete-form" action="{{ route('course_category.delete', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $category->id }}">
            </form>
        </div>
    </div>
@endsection
