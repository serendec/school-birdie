@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">アカウント情報</h1>
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="editcase">
                            <div class="editcase-left">
                                <div class="namebox">
                                    @include('partials.icon', [
                                        'icon' => $teacher->icon,
                                        'size' => 'default',
                                    ])
                                    <div>
                                        <div class="text size-mini block">
                                            {{ $teacher->family_name_kana }}　{{ $teacher->first_name_kana }}
                                        </div>
                                        <h1 class="text size-default weight-normal ma-0">
                                            {{ $teacher->family_name }}　{{ $teacher->first_name }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->role == 'admin' || Auth::user()->id == $teacher->id)
                                <div class="editcase-right">
                                    <a href="{{ route('teacher.edit', $teacher->id) }}" class="button button-secondary">
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
                <div class="detail-content-header">連絡先</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">電話番号</div>
                        <div class="text size-middle block">
                            {{ $teacher->tel ?? '未設定' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">メール</div>
                        <div class="text size-middle block">
                            {{ $teacher->email ?? '未設定' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">LINE ID</div>
                        <div class="text size-middle block">
                            {{ $teacher->line_id ?? '未設定' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content noedit">
                <div class="detail-content-header">担当</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">メイン</div>
                        <div class="text size-middle block">
                            {{ $teacher->students->where('category', 'main')->count() }}名
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">サブ</div>
                        <div class="text size-middle block">
                            {{ $teacher->students->where('category', 'sub')->count() }}名
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content noedit">
                <div class="detail-content-header">登録日</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            {{ $teacher->created_at->format('Y/m/d') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
