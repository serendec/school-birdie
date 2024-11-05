@extends('layouts.super_admin-app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">スクール管理</h1>

        {{-- <div class="listcontrol">
            <div class="listcontrol-left">
                <a href="{{ route('school.create') }}" class="button button-primary">
                    <span class="text">アカウント発行</span>
                </a>
            </div>
        </div> --}}

        @if ($schools->isEmpty())
            <div class="empty">
                スクールの登録がありません。
            </div>
        @else
            @foreach ($schools as $school)
                <div class="card no-action">
                    <div class="card-content">
                        <div class="card-name">
                            <span class="namebox">
                                @include('partials.icon', ['icon' => $school->icon, 'size' => 'default'])
                                <span>
                                    <span class="text size-default">{{ $school->name }}</span>
                                </span>
                            </span>
                        </div>
                        <hr />
                        <div class="detail-content">
                            <div class="detail-content-body">
                                <div class="detail-content-body-item">
                                    <div class="text size-mini block">アカウント登録日</div>
                                    <div class="text size-middle block">
                                        {{ $school->created_at->format('Y/m/d') }}
                                    </div>
                                </div>
                                <div class="detail-content-body-item">
                                    <div class="text size-mini block">契約プラン</div>
                                    <div class="text size-middle block">
                                        {{ config("school.{$school->id}") ? config("school.{$school->id}")['plan'] : '未設定' }}
                                    </div>
                                </div>
                                <div class="detail-content-body-item">
                                    <div class="text size-mini block">使用容量</div>
                                    <div class="text size-middle block">
                                        @if ($school->storage_usage && $school->storage_usage > 0)
                                            {{ $school->storage_usage }} GB

                                            @if (config("school.{$school->id}")
                                                && config("school.{$school->id}")['storage_limit'] > 0
                                                && $school->storage_usage > config("school.{$school->id}")['storage_limit'])
                                                <span class="texticon type-alert ml-16">容量オーバー</span>
                                            @endif
                                        @else
                                            0 GB
                                        @endif
                                    </div>
                                </div>
                                <div class="detail-content-body-item">
                                    <div class="text size-mini block">決済利用制限状況</div>
                                    <div class="text size-middle block">
                                        <div class="switch-container" data-school_id="{{ $school->id }}">
                                            <label class="switch">
                                                <span class="slider {{ $school->payment_restriction == '1' ? 'active' : '' }}"></span>
                                            </label>
                                            <span class="switch-text">{{ $school->payment_restriction == '1' ? '制限中' : '制限なし' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const switchContainers = document.querySelectorAll('.switch-container');
            switchContainers.forEach(container => {
                const slider = container.querySelector('.slider');
                const switchText = container.querySelector('.switch-text');
                const schoolId = container.dataset.school_id;
                let isRestricted = slider.classList.contains('active');

                slider.addEventListener('click', () => {
                    // disabledクラスがある場合は処理を中断
                    if (slider.classList.contains('disabled')) {
                        return;
                    }
                    
                    // ローディングインジケーターを表示 & スイッチを無効化
                    const loadingIndicator = document.createElement('div');
                    loadingIndicator.classList.add('loading-indicator');
                    container.appendChild(loadingIndicator);
                    slider.classList.add('disabled');

                    // AJAXで決済利用制限の状態を更新
                    fetch(`/super-admin/school/update`, {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            school_id: schoolId,
                            is_restricted: !isRestricted
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            alert('エラーが発生しました。時間をおいて再度お試しください。エラー01');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'error') {
                            throw new Error(data.message);
                        }

                        isRestricted = !isRestricted;
                        updateSwitchAppearance();
                    })
                    .catch(error => {
                        alert('エラーが発生しました。時間をおいて再度お試しください。エラー02');
                    })
                    .finally(() => {
                        // ローディングインジケーターを削除 & スイッチを有効化
                        container.removeChild(loadingIndicator);
                        slider.classList.remove('disabled');
                    });
                });

                function updateSwitchAppearance() {
                    slider.classList.toggle('active', isRestricted);
                    switchText.textContent = isRestricted ? '制限中' : '制限なし';
                }
            });
        });
    </script>
@endsection
