@extends('layouts.app')

@section('content')
    @php
        $top_img_path = (Auth::user()->school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . Auth::user()->school->top_img : '/storage/img/default-top.jpg';
    @endphp
    <div class="imagebg" style="background-image: url({{ $top_img_path }});">
        <div class="imagebg-gra">
            <div class="imagebg-gra-content">
                <h1 class="hd-1">フォーラム</h1>
                    @can('isStudent')
                        <div class="listcontrol">
                            <div class="listcontrol-left">
                                <p class="text size-mini">
                                    スクール内の講師・生徒と<br class="sp" />交流しましょう！
                                </p>
                            </div>
                        </div>
                        <div class="listcontrol mt-24">
                            <div class="listcontrol-left">
                                <a href="{{ route('forum.create') }}" class="button button-primary">
                                    <span class="text">新規作成</span>
                                </a>
                            </div>
                        </div>
                    @elsecan('isTeacher')
                        <div class="listcontrol mt-24">
                            <div class="listcontrol-left">
                                <a href="{{ route('forum.create') }}" class="button button-primary">
                                    <span class="text">新規作成</span>
                                </a>
                            </div>
                        </div>
                    @endcan
                    
                    <div class="listcontrol mt-24 fit-bottom">
                        <div class="listcontrol-left">
                            <div>
                                @if ($rankedTags)
                                    <h2 class="hd-2 ma-0 weight-bold">おすすめタグ</h2>
                                    <span class="tagbox mt-8">
                                        @foreach ($rankedTags as $tag)
                                            <a href="{{ route('forum.search', ['tag_ids' => [$tag->id]]) }}" class="tag">{{ $tag->name }}</a>
                                        @endforeach
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="listcontrol-right">
                            <span class="button button-secondary" id="filter-button">
                                <span class="material-symbols-outlined">
                                    filter_list
                                </span>
                                <span class="text">(<span id="filteredCount">{{ $filteredCount ?? 0 }}</span>)</span>
                            </span>
                            <form action="{{ route('forum.search') }}" method="GET">
                                <div class="filterlist" id="filterlist">
                                    <div class="inputset">
                                        <label for="input-title" class="text size-mini block">タイトル</label>
                                        <div class="text size-middle block">
                                            <input id="input-title" type="text" name="title" value="{{ request()->input('title') ?? '' }}" maxlength="20">
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="inputset">
                                        <label for="input-tag" class="text size-mini block">タグ</label>
                                        <div class="text size-middle block">
                                            <select id="input-tag">
                                                <option value="">選択してください</option>
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="tagbox" id="tag-list">
                                            @if (isset($selectedTags) && $selectedTags != [])
                                                @foreach ($selectedTags as $selectedTag)
                                                    <span class="tag">
                                                        {{ $selectedTag->name }}
                                                        <button type="button" class="material-symbols-outlined">close</button>
                                                        <input type="hidden" name="tag_ids[]" value="{{ $selectedTag->id }}">
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="inputset">
                                        <label for="input-from" class="text size-mini block">期間</label>
                                        <div class="text size-middle block">
                                            <input id="input-from" name="from" type="date" value="{{ request()->input('from') ?? '' }}"><br> 〜 <input id="input-to" name="to" type="date" value="{{ request()->input('to') ?? '' }}">
                                        </div>
                                    </div>
                                    <hr />

                                    @can('isTeacher')
                                        <div class="inputset">
                                            <label for="select-user" class="text size-mini block">作成者</label>
                                            <div class="text size-middle block">
                                                <select id="select-user" name="user_id">
                                                    <option value="">選択してください</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}" {{ request()->input('user_id') == $user->id ? 'selected' : '' }}>{{ $user->family_name }}　{{ $user->first_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <hr />
                                    @endcan

                                    <span class="text size-mini">ステータス</span>
                                    <ul>
                                        <li>
                                            <label><input type="checkbox" name="unread" id="unread" value="unread" {{ request()->input('unread') == 'unread' ? 'checked' : '' }}>未読あり</label>
                                        </li>
                                    </ul>
                                    <hr />

                                    <div class="buttonset">
                                        <button class="button button-primary" type="submit">
                                            <span class="text">絞り込み</span>
                                        </button>
                                        <button id="filter-reset-button" class="button button-secondary" type="button">
                                            <span class="text">リセット</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($forums->isEmpty())
            <div class="empty">トピックはまだありません。</div>
        @else
            <div class="site-body-wrapper">
                @foreach ($forums as $forum)
                    <a class="card" href="{{ route('forum.show', $forum->id) }}">
                        <span class="card-content">
                            <span class="card-header">
                                @if (in_array($forum->id, $unreadForumIds))
                                    <span class="texticon type-new">未読</span>
                                @endif
                                <span class="text size-mini">{{ $forum->created_at->format('Y/m/d') }}</span>
                                <span class="namebox">
                                    @include('partials.icon', ['icon' => $forum->user->icon, 'size' => 'mini'])
                                    <span>
                                        <span class="text size-mini">{{ $forum->user->family_name }} {{ $forum->user->first_name }}</span>
                                    </span>
                                </span>
                            </span>
                            <span class="card-name">
                                <span class="namebox">
                                    <span>
                                        <span class="text size-default">{{ $forum->title }}</span>
                                    </span>
                                </span>
                            </span>
                            <span class="tagbox">
                                @foreach ($forum->tags as $tag)
                                    <span class="tag">{{ $tag->name }}</span>
                                @endforeach
                            </span>
                            <span class="card-footer">
                                <span class="socialdisplay">
                                    <span class="material-symbols-outlined">
                                        thumb_up
                                    </span>
                                    <span class="text size-mini">{{ $forum->likes->count() }}</span>
                                </span>
                                <span class="socialdisplay">
                                    <span class="material-symbols-outlined">
                                        comment
                                    </span>
                                    <span class="text size-mini">{{ $forum->comments->count() }}</span>
                                </span>
                            </span>
                        </span>
                        <span class="card-arrow">
                            <span class="material-symbols-outlined">
                                chevron_right
                            </span>
                        </span>
                    </a>
                @endforeach

                {{ $forums->withQueryString()->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
@endsection

@section('js-footer')
    <script src="{{ asset('js/tag.js') }}"></script>
@endsection
