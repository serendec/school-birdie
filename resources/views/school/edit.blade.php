@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">編集</h1>
        <div class="detail">
            <form method="post" action="{{ route('school.update') }}" class="formlist" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="detail-content">
                    <div class="detail-content-header">名称</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-name" class="text size-mini block">
                                    スクール名
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="name" id="input-name" value="{{ old('name', $school->name) }}" size="40" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-content">
                    <div class="detail-content-header">概要</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-url" class="text size-mini block">
                                    公式ホームページURL
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-url" name="url" value="{{ $school->url }}" size="40" />
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tel" class="text size-mini block">
                                    お問い合わせ先電話番号
                                    <span class="texticon type-require">必須</span>
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-tel" name="tel" value="{{ $school->tel }}" size="13" />
                                </div>
                                <div class="text size-mini block">ハイフンなし（例：0312345678）</div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tel_available_time" class="text size-mini block">
                                    電話受付時間
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" name="tel_available_time" id="input-tel_available_time" value="{{ $school->tel_available_time }}" size="40">
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-email" class="text size-mini block">
                                    お問い合わせ先メールアドレス
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-email" name="email" value="{{ $school->email }}" size="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-content">
                    <div class="detail-content-header">画像</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="icon" class="text size-mini block">
                                    アイコン
                                </label>
                                <div class="text size-middle block">
                                    <span class="namebox">
                                        @include('partials.icon', [
                                            'icon' => $school->icon,
                                            'size' => 'default',
                                            'id'   => 'icon-select'
                                        ])
                                        <span class="text size-default">
                                            <span class="button button-secondary" id="button-select_file">
                                                <span class="text">ファイル選択</span>
                                            </span>
                                            <input type="file" name="icon" id="icon" accept=".png,.jpg,.jpeg" hidden>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-file" class="text size-mini block">
                                    トップ画面背景
                                </label>
                                <div class="text size-middle block">
                                    <span class="namebox">
                                        @php
                                            $img_path = ($school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . $school->top_img : '/storage/img/default-top.jpg';
                                        @endphp
                                        <span class="avator size-default" style="background-image:url('{{ $img_path }}');border-radius:0;" id="selected_top_img"></span>
                                        <span class="text size-default mr-8">
                                            <span class="button button-secondary" id="button-select_img_file">
                                                <span class="text">ファイル選択</span>
                                            </span>
                                            <input type="file" name="top_img" id="input-file" accept=".png,.jpg,.jpeg" hidden>
                                        </span>
                                        <label><input type="checkbox" name="clear_top_img" value="1">初期化</label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-content">
                    <div class="detail-content-header">特定商取引法に基づく表記</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-company-name" class="text size-mini block">
                                    販売事業所名
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-tokushoho-company-name" name="tokushoho_company_name" value="{{ old('tokushoho_company_name', $school->tokushoho_company_name ?? $school->name) }}" size="40" />
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-address" class="text size-mini block">
                                    所在地
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_address" id="input-tokushoho-address" rows="3" cols="50">{{ old('tokushoho_address', $school->tokushoho_address) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-tel" class="text size-mini block">
                                    電話番号
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-tokushoho-tel" name="tokushoho_tel" value="{{ old('tokushoho_tel', $school->tokushoho_tel ?? $school->tel) }}" size="13" />
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-email" class="text size-mini block">
                                    メールアドレス
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-tokushoho-email" name="tokushoho_email" value="{{ old('tokushoho_email', $school->tokushoho_email ?? $school->email) }}" size="40" />
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-representative" class="text size-mini block">
                                    運営統括責任者
                                </label>
                                <div class="text size-middle block">
                                    <input type="text" id="input-tokushoho-representative" name="tokushoho_representative" value="{{ old('tokushoho_representative', $school->tokushoho_representative) }}" size="40" />
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-additional-fees" class="text size-mini block">
                                    追加手数料等の追加料金
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_additional_fees" id="input-tokushoho-additional-fees" rows="2" cols="50">{{ old('tokushoho_additional_fees', $school->tokushoho_additional_fees) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-refund-policy" class="text size-mini block">
                                    返金ポリシー
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_refund_policy" id="input-tokushoho-refund-policy" rows="3" cols="50">{{ old('tokushoho_refund_policy', $school->tokushoho_refund_policy) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-delivery-time" class="text size-mini block">
                                    引渡時期
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_delivery_time" id="input-tokushoho-delivery-time" rows="2" cols="50">{{ old('tokushoho_delivery_time', $school->tokushoho_delivery_time) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-payment-method" class="text size-mini block">
                                    お支払い方法
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_payment_method" id="input-tokushoho-payment-method" rows="2" cols="50">{{ old('tokushoho_payment_method', $school->tokushoho_payment_method) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-payment-period" class="text size-mini block">
                                    決済期間
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_payment_period" id="input-tokushoho-payment-period" rows="2" cols="50">{{ old('tokushoho_payment_period', $school->tokushoho_payment_period) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-price" class="text size-mini block">
                                    販売価格
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_price" id="input-tokushoho-price" rows="2" cols="50">{{ old('tokushoho_price', $school->tokushoho_price) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-validity-period" class="text size-mini block">
                                    お申込み有効期限
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_validity_period" id="input-tokushoho-validity-period" rows="2" cols="50">{{ old('tokushoho_validity_period', $school->tokushoho_validity_period) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-sales-quantity" class="text size-mini block">
                                    販売数量
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_sales_quantity" id="input-tokushoho-sales-quantity" rows="2" cols="50">{{ old('tokushoho_sales_quantity', $school->tokushoho_sales_quantity) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="inputset">
                                <label for="input-tokushoho-usage-method" class="text size-mini block">
                                    ご利用方法
                                </label>
                                <div class="text size-middle block">
                                    <textarea name="tokushoho_usage_method" id="input-tokushoho-usage-method" rows="2" cols="50">{{ old('tokushoho_usage_method', $school->tokushoho_usage_method) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

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

@section('js-footer')
    <script src="{{ asset('js/user.js') }}" defer></script>
@endsection
