@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">タグ管理</h1>

        <div class="listcontrol">
            <div class="listcontrol-left">
                <a href="{{ route('tag.create') }}" class="button button-primary">
                    <span class="text">新規作成</span>
                </a>
            </div>
        </div>

        @if ($tags->isEmpty())
            <div class="empty">タグが登録されていません。</div>
        @else
            <ul class="buttonlist">
                @foreach ($tags as $tag)
                    <li>
                        <a href="{{ route('tag.edit', $tag->id) }}" class="button button-secondary">
                            <span class="text">{{ $tag->name }}</span>
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
