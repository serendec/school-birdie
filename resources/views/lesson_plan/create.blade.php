@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">新規作成</h1>
        <div class="detail">
            <form method="post" action="{{ route('lesson_plan.store') }}" class="formlist">
                @csrf
                <div class="detail-content">
                    <div class="detail-content-body">
                        <div class="detail-content-body-item ma-0">
                            <div class="inputset">
                                <label for="input-name" class="text size-mini block">
                                    プラン名
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="name" id="input-name" size="40" value="{{ old('name') ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="detail-content">
                    <div class="detail-content-header">決済設定</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-price" class="text size-mini block">
                                    料金（税抜）
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="price" id="input-price" size="40" value="{{ old('price') ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-stripe_plan_id" class="text size-mini block">
                                    Stripeで設定した商品の「API ID」
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="stripe_plan_id" id="input-stripe_plan_id" size="40" value="{{ old('stripe_plan_id') ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="detail-content">
                    <div class="detail-content-header">サービス設定</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label class="text size-mini block">
                                    講座
                                </label>
                                <div>
                                    <label class="text size-middle mode-button">
                                        <input type="radio" name="course_available" id="input-course_available-1" value="1" {{ (old('course_available') == '1' || old('course_available') == null) ? 'checked' : '' }}>使用できる
                                    </label>
                                    <label class="text size-middle mode-button">
                                        <input type="radio" name="course_available" id="input-course_available-0" value="0" {{ old('course_available') == '0' ? 'checked' : '' }}>使用できない
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label class="text size-mini block">
                                    レッスン記録
                                </label>
                                <div>
                                    <label class="text size-middle mode-button">
                                        <input type="radio" name="lesson_record_available" id="input-lesson_record_available-1" value="1" {{ (old('lesson_record_available') == '1' || old('lesson_record_available') == null) ? 'checked' : '' }}>使用できる
                                    </label>
                                    <label class="text size-middle mode-button">
                                        <input type="radio" name="lesson_record_available" id="input-lesson_record_available-0" value="0" {{ old('lesson_record_available') == '0' ? 'checked' : '' }}>使用できない
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label class="text size-mini block">
                                    動画添削
                                </label>
                                <div>
                                    <label class="text size-middle mode-button">
                                        <input type="radio" name="video_advice_available" id="input-video_advice_available-1" value="1" {{ (old('video_advice_available') == '1' || old('video_advice_available') == null) ? 'checked' : '' }}>使用できる
                                    </label>
                                    <label class="text size-middle mode-button">
                                        <input type="radio" name="video_advice_available" id="input-video_advice_available-0" value="0" {{ old('video_advice_available') == '0' ? 'checked' : '' }}>使用できない
                                    </label>
                                </div>
                                <div class="outline in-content">
                                    <div class="outline-content">
                                        <div class="inputset">
                                            <label for="input-video_advice_num" class="text size-mini block">月の依頼回数</label>
                                            <span class="text size-middle block">
                                                <span class="text size-middle block">
                                                    最大
                                                    <input type="number" id="input-video_advice_num" name="video_advice_num" class="digits-2 ta-right" value="{{ old('video_advice_num') ?? '' }}">
                                                    回まで
                                                </span>
                                            </span>
                                        </div>
                                        <div class="inputset mt-16">
                                            <label for="input-video_advice_automatically_close_period" class="text size-mini block">依頼対応期間</label>
                                            <span class="text size-middle block">
                                                <span class="text size-middle block">
                                                    依頼後
                                                    <input type="number" id="input-video_advice_automatically_close_period" class="digits-2 ta-right" name="video_advice_automatically_close_period" value="{{ old('video_advice_automatically_close_period') ?? '' }}">
                                                    日間対応できる
                                                </span>
                                            </span>
                                        </div>
                                        <div class="text size-mini block note mt-8">
                                            期間後、自動で対応完了となります。<br>
                                            指定がない場合は無制限となります。
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label class="text size-mini block">
                                    フォーラム
                                </label>
                                <div>
                                    <label class="text size-middle mode-button">
                                        <input type="radio" name="forum_available" id="input-forum_available-1" value="1" {{ (old('forum_available') == '1' || old('forum_available') == null) ? 'checked' : '' }}>使用できる
                                    </label>
                                    <label class="text size-middle mode-button">
                                        <input type="radio" name="forum_available" id="input-forum_available-0" value="0" {{ old('forum_available') == '0' ? 'checked' : '' }}>使用できない
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />

                <div class="edit-footer">
                    <div class="edit-footer-left">
                        <button type="submit" class="button button-primary">
                            <span class="text">保存</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
