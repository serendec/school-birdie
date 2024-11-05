@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">順序変更</h1>
        <div class="listcontrol ma-0">
            <div class="listcontrol-left">
                <p class="text size-default">
                    項目にタッチし、そのまま指を動かして、希望の場所に持っていくと変更できます。
                </p>
            </div>
        </div>
        
        @if ($categories->isEmpty())
            <div class="empty">講座カテゴリが登録されていません。</div>
        @else
            <ul id="sortable" class="buttonlist">
                @foreach ($categories as $category)
                    <li data-id="{{ $category->id }}">
                        <span class="button button-secondary jc-init" aria-label="順序変更用ドラッグハンドル">
                            <span class="material-symbols-outlined">
                                drag_handle
                            </span>
                            <span class="text">{{ $category->name }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection

@section('js-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 並び替え機能
            const sortable = new Sortable(document.getElementById('sortable'), {
                animation: 150,
                handle: '.button',
                onUpdate: function(evt) {
                    // カテゴリのIDをソート順に配列で取得
                    const categoryIds = Array.from(evt.target.children).map(tr => tr.dataset.id);

                    // ソート順を更新
                    fetch('/course_category/update_order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            categoryIds: categoryIds
                        })
                    }).catch(error => {
                        alert('カテゴリの並び替えに失敗しました。');
                    });
                }
            });
        });
    </script>
@endsection
