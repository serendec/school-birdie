@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">契約情報</h1>
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">契約プラン</div>
                        <div class="text size-middle block">{{ $schoolPlan }}</div>
                    </div>

                    <div class="detail-content-body-item">
                        <div class="text size-mini block">使用容量</div>
                        <div class="text size-middle block">
                            {{ $storageUsage }} GB
                            @if ($overStorage)
                                <span class="texticon type-alert ml-16">容量オーバー</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
