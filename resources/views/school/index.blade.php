@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">スクール情報</h1>
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="editcase">
                            <div class="editcase-left">
                                <div class="namebox">
                                    @include('partials.icon', [
                                        'icon' => $school->icon,
                                        'size' => 'default',
                                    ])
                                    <div>
                                        <h1 class="text size-default weight-normal">
                                            {{ $school->name }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            @can('isAdmin')
                                <div class="editcase-right">
                                    <a href="{{ route('school.edit') }}" class="button button-secondary">
                                        <span class="text">編集</span>
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="detail-content">
                <div class="detail-content-header">概要</div>
                <div class="detail-content-body">
                    @if ($school->url != null)
                        <div class="detail-content-body-item">
                            <div class="text size-mini block">公式ホームページURL</div>
                            <div class="text size-middle block">
                                <a href="{{ $school->url }}" target="_blank">{{ $school->url }}</a>
                            </div>
                        </div>
                    @endif

                    <div class="detail-content-body-item">
                        <div class="text size-mini block">お問い合わせ先電話番号</div>
                        <div class="text size-middle block">
                            <a href="tel:{{ $school->tel }}">{{ $school->tel }}</a>
                        </div>
                    </div>

                    @if ($school->tel_available_time != null)
                        <div class="detail-content-body-item">
                            <div class="text size-mini block">電話受付時間</div>
                            <div class="text size-middle block">
                                {{ $school->tel_available_time }}
                            </div>
                        </div>
                    @endif

                    @if ($school->email != null)
                        <div class="detail-content-body-item">
                            <div class="text size-mini block">お問い合わせ先メールアドレス</div>
                            <div class="text size-middle block">
                                <a href="mailto:{{ $school->email }}">{{ $school->email }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="detail-content">
                <div class="detail-content-header">トップ画面背景</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            @if ($school->top_img)
                                <img src="/storage/img/{{ Auth::user()->school_id.'/'.$school->top_img }}" class="wfull" alt="トップ画面背景" />
                            @else
                                <span class="text size-middle">デフォルト</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
