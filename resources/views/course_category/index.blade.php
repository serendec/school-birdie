@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">講座カテゴリ</h1>

        <div class="listcontrol">
            <div class="listcontrol-left">
                <a href="{{ route('course_category.create') }}" class="button button-primary">
                    <span class="text">新規作成</span>
                </a>
                @if (!$categories->isEmpty())
                    <a href="{{ route('course_category.update_order_index') }}" class="button button-secondary">
                        <span class="text">順序変更</span>
                    </a>
                @endif
            </div>
        </div>

        @if ($categories->isEmpty())
            <div class="empty">講座カテゴリが登録されていません。</div>
        @else
            <ul class="buttonlist">
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('course_category.edit', $category->id) }}" class="button button-secondary">
                            <span class="text">{{ $category->name }}</span>
                            <span class="label-icon">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
