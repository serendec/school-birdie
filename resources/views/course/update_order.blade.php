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
            <div class="empty">講座が登録されていません。</div>
        @else
            @foreach ($categories as $category)
                @php
                    if ($category->courses->isEmpty()) {
                        continue;
                    }
                @endphp
                <p>{{ $category->name }}</p>
                <ul id="sortable" class="buttonlist ma-0 courses-container" data-category_id="{{ $category->id }}">
                    @foreach ($category->courses as $course)
                        <li data-id="{{ $course->id }}">
                            <span class="button button-secondary" aria-label="順序変更用ドラッグハンドル">
                                <span class="material-symbols-outlined">
                                    drag_handle
                                </span>
                                <span class="text">{{ $course->title }}</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        @endif
    </div>
@endsection

@section('js-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Sortable.js for courses within each category
            const courseContainers = document.querySelectorAll('.courses-container');
            courseContainers.forEach(function(container) {
                new Sortable(container, {
                    animation: 150,
                    handle: '.button',
                    onUpdate: function(evt) {
                        const categoryId = evt.target.dataset.category_id;
                        const courseIds = Array.from(evt.target.children).map(li => li.dataset.id);
                        fetch('/course/update_order', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                categoryId: categoryId,
                                courseIds: courseIds
                            })
                        }).then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText);
                            }
                            return response.json();
                        }).then(data => {
                            console.log(data);
                        }).catch(error => {
                            console.error('Error updating category order:', error);
                        });
                    }
                });
            });
        });
    </script>
@endsection
