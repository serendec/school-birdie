@extends('layouts.app')

@section('content')
    @php
        $top_img_path = (Auth::user()->school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . Auth::user()->school->top_img : null;
    @endphp
    <div class="imagebg" style="background-image: url({{ $top_img_path }});">
        <div class="imagebg-gra">
            <div class="imagebg-gra-content">
                <h1 class="hd-1">お気に入り動画</h1>
                    <div class="listcontrol">
                        <div class="listcontrol-left"></div>
                    </div>
                </div>
            </div>
        </div>

        @if ($favorites->isEmpty())
            <div class="empty">
                お気に入り動画はありません。
            </div>
        @else
            <div class="site-body-wrapper">
                @foreach ($favorites as $index => $favorite)
                    <div class="card card-movie no-action">
                        <span class="card-content">
                            <div class="editcase">
                                <div class="editcase-left">
                                    <span class="card-header">
                                        <span class="text size-mini">{{ $favorite->favoritable->created_at->format('Y/m/d') ?? '' }}</span>
                                        <span class="texticon type-done">{{ $favorite->video_category == 'lesson_record' ? 'レッスン記録' : '動画添削' }}</span>
                                    </span>
                                    <span class="card-name mt-8">
                                        <span class="namebox">
                                            <span>
                                                <span class="text size-default">{{ $favorite->favoritable->title ?? '' }}</span>
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div class="editcase-right">
                                    <a class="button button-secondary" href="{{ route($favorite->video_category.'.show', $favorite->favoritable->id) }}">
                                        詳細
                                    </a>
                                </div>
                            </div>
                            <div class="video-container">
                                <video id="video-player-{{ $index + 1 }}" controls></video>
                                <button class="favorite-btn" data-video="{{ $favorite->video }}" data-video_category="{{ $favorite->video_category }}" data-video_category_id="{{ $favorite->video_category_id }}">
                                    <i class="fa fa-heart favorited"></i>
                                </button>
                            </div>
                        </span>
                    </div>
                @endforeach

                {{ $favorites->withQueryString()->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
@endsection

@section('js-footer')
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script src="{{ asset('js/comment.js') }}"></script>
    <script src="{{ asset('js/hls.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // HLS読み込み
            const videoSources = [
                @foreach ($favorites as $favorite)
                    "{{ $favorite->video ? asset('storage/media/' . $favorite->video_category . '/' . Auth::user()->school_id . '/' . $favorite->video_category_id . '/' . $favorite->video . '.m3u8') : '' }}",
                @endforeach
            ];
            videoSources.forEach((source, index) => {
                if (!source) {
                    return;
                }

                const video = document.getElementById(`video-player-${index + 1}`);
                
                if (Hls.isSupported()) {
                    const hls = new Hls();
                    hls.loadSource(source);
                    hls.attachMedia(video);
                } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
                    video.src = source;
                } else {
                    alert("動画再生に対応していないブラウザです。\nお手数でございますが、別のブラウザをご利用ください。");
                    return;
                }

                video.style.display = "block";
            });
        });
    </script>
@endsection
