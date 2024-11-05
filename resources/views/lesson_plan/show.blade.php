@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="editcase">
                            <div class="editcase-left">
                                <div class="namebox">
                                    <div>
                                        <h1 class="text size-default weight-normal">
                                            {{ $lessonPlan->name }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            @can('isAdmin')
                                <div class="editcase-right">
                                    <a href="{{ route('lesson_plan.edit', $lessonPlan->id) }}" class="button button-secondary">
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
                <div class="detail-content-header">決済設定</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">料金（税抜）</div>
                        <div class="text size-middle block">
                            {{ $lessonPlan->price ? number_format($lessonPlan->price) : '未設定' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">Stripeで設定した商品の「API ID」</div>
                        <div class="text size-middle block">
                            {{ $lessonPlan->stripe_plan_id ? '設定済み' : '未設定'}}
                        </div>
                    </div>
                </div>
            </div>
            <hr />

            <div class="detail-content">
                <div class="detail-content-header">サービス設定</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">講座</div>
                        <div class="text size-middle block">
                            {{ $lessonPlan->course_available == 0 ? '使用できない' : '使用できる' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">レッスン記録</div>
                        <div class="text size-middle block">
                            {{ $lessonPlan->lesson_record_available == 0 ? '使用できない' : '使用できる' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">動画添削</div>
                        <div class="text size-middle block">
                            {{ $lessonPlan->video_advice_available == 0 ? '使用できない' : '使用できる' }}
                        </div>
                        @if ($lessonPlan->video_advice_available != 0)
                            <div class="outline in-content mt-8">
                                <div class="outline-content">
                                    <div class="inputset">
                                        <label for="text1" class="text size-mini block">月の依頼回数</label>
                                        <span class="text size-middle block">
                                            {{ $lessonPlan->video_advice_num ? '最大'.$lessonPlan->video_advice_num.'回まで' : '未設定' }}
                                        </span>
                                    </div>
                                    <div class="inputset mt-16">
                                        <label for="text1" class="text size-mini block">依頼対応期間</label>
                                        <span class="text size-middle block">
                                            {{ $lessonPlan->video_advice_automatically_close_period ? '依頼後'.$lessonPlan->video_advice_automatically_close_period.'日間対応できる' : '未設定' }}
                                        </span>
                                    </div>
                                    <div class="text size-mini block note mt-8">
                                        期間後、自動で対応完了となります。<br>
                                        指定がない場合は無制限となります。
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">フォーラム</div>
                        <div class="text size-middle block">
                            {{ $lessonPlan->forum_available == 0 ? '使用できない' : '使用できる' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
