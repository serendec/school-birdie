@extends('layouts.login')

@section('content')
    @if (count($errors) > 0)
        <div class="infomessage type--error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h1 class="screen-heading">{{ $lessonPlans ? '生徒' : '講師' }} ユーザー登録</h1>
    <section class="flat-content">
        <form method="post" action="/register" id="register-form" class="form" enctype="multipart/form-data">
            @csrf
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-name-sei">アイコン</label>
                </div>
                <div class="formlist-line-main">
                    <div class="inputset">
                        <label for="icon" class="text size-mini block">
                            アイコン
                        </label>
                        <div class="text size-middle block">
                            <span class="namebox">
                                @include('partials.icon', [
                                    'icon' => null,
                                    'size' => 'default',
                                    'id'   => 'icon-select'
                                ])
                                <span class="text size-default">
                                    <span class="button button-secondary" id="button-select_file">
                                        <span class="text">ファイル選択</span>
                                    </span>
                                    <input type="file" name="icon" id="icon" accept=".png, .jpg" hidden>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-name-sei">氏名</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <label for="family_name">姓</label>
                            <div class="with-notes notes-bottom">
                                <input type="text" id="family_name" name="family_name" value="{{ old('family_name') }}" />
                            </div>
                        </div>
                        <div class="inputset">
                            <label for="first_name">名</label>
                            <div class="with-notes notes-bottom">
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-name-sei-kana">しめい（かな）</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <label for="family_name_kana">せい</label>
                            <div class="with-notes notes-bottom">
                                <input type="text" id="family_name_kana" name="family_name_kana" value="{{ old('family_name_kana') }}" />
                            </div>
                        </div>
                        <div class="inputset">
                            <label for="first_name_kana">めい</label>
                            <div class="with-notes notes-bottom">
                                <input type="text" id="first_name_kana" name="first_name_kana" value="{{ old('first_name_kana') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-tel">電話番号</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input type="text" name="tel" id="input-tel" value="{{ old('tel') }}" />
                                <span class="notes">ハイフンなし（例：0398760023）</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line reg-fax">
                <div class="formlist-line-side">
                    <label for="input-fax">FAX</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input type="text" name="fax" id="input-fax" value="" />
                                <span class="notes">ハイフンなし（例：0398760024）</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-mail">メールアドレス</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div>
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input id="input-mail" class="wfull" type="text" name="email" value="{{ old('email') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-lineid">LINE ID</label>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input id="input-lineid" type="text" name="line_id" value="{{ old('line_id') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-password">パスワード</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input id="input-password" type="password" name="password" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formlist-line">
                <div class="formlist-line-side">
                    <label for="input-password_confirmation">パスワード再入力</label><span class="texticon type--require">必須</span>
                </div>
                <div class="formlist-line-main">
                    <div class="input-column">
                        <div class="inputset">
                            <div class="with-notes notes-bottom">
                                <input id="input-password_confirmation" type="password" name="password_confirmation" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($lessonPlans && count($lessonPlans) > 0)
                <div class="formlist-line">
                    <div class="formlist-line-side">
                        <label for="lesson_plan_id">受講プラン</label><span class="texticon type--require">必須</span>
                    </div>
                    <div class="formlist-line-main">
                        <div class="input-column">
                            <div class="inputset">
                                <div class="with-notes notes-bottom">
                                    <select name="lesson_plan_id" id="lesson_plan_id" required>
                                        <option value="" data-use_stripe="false" selected>選択してください</option>
                                        @foreach ($lessonPlans as $lessonPlan)
                                            <option value="{{ $lessonPlan->id }}" data-use_stripe="{{ $lessonPlan->stripe_plan_id != null ? 'true' : 'false' }}">{{ $lessonPlan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($stripePublicKey)
                    <div id="stripe-div" class="formlist-line">
                        <div class="formlist-line-side">
                            <label for="card-number-element">クレジットカード</label><span class="texticon type--require">必須</span>
                        </div>
                        <div class="formlist-line-main">
                            <div class="input-column">
                                <div class="inputset">
                                    <div class="with-notes notes-bottom">
                                        <div id="card-number-element"></div>
                                        <div class="form-row">
                                            <div id="card-expiry-element"></div>
                                            <div id="card-cvc-element"></div>
                                        </div>
                                        <div id="card-errors" role="alert"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="formlist-last">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                <div class="input-column">
                    <div class="button-container">
                        <input type="hidden" name="token" value="{{ $token ?? '' }}">
                        <input type="hidden" name="form_loaded_at" value="{{ time() }}">
                        <input type="hidden" name="js_challenge_result" id="jsChallengeResult" value="">
                        <button type="submit" class="button type--first" id="submit-button">登録</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
@section('js-footer')
    <script src="{{ asset('js/user.js') }}" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('jsChallengeResult').value = 3 + 4;
        });
    </script>
    @if ($stripePublicKey)
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            // Stripe
            const stripe = Stripe('{{ $stripePublicKey }}');
            const elements = stripe.elements();
            const style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '14px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            const cardNumber = elements.create('cardNumber', {
                style: style,
                showIcon: true
            });
            cardNumber.mount('#card-number-element');
            const cardExpiry = elements.create('cardExpiry', {style: style});
            cardExpiry.mount('#card-expiry-element');
            const cardCvc = elements.create('cardCvc', {style: style});
            cardCvc.mount('#card-cvc-element');

            cardNumber.addEventListener('change', ({error}) => {
                const displayError = document.getElementById('card-errors');
                if (error) {
                    displayError.textContent = error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            
            // 受クレジットカード入力欄の制御
            document.getElementById('lesson_plan_id').addEventListener('change', function() {
                const selectedPlan = this.options[this.selectedIndex];
                if (selectedPlan.getAttribute('data-use_stripe') == 'false') {
                    document.getElementById('stripe-div').classList.remove('disp-card');
                } else {
                    document.getElementById('stripe-div').classList.add('disp-card');
                }
            });

            // 送信ボタン押下時の処理
            const submit = document.getElementById('submit-button');
            const family_name = document.getElementById('family_name');
            const first_name = document.getElementById('first_name');
            const full_name = family_name.value + first_name.value;
            const email = document.getElementById('email');
            submit.addEventListener('click', async(e) => {
                e.preventDefault();
                // 選択されたプランのStripe設定がfalseの場合は、stripeの処理をスキップ
                const lessonPlanId = document.getElementById('lesson_plan_id');
                const selectedPlan = lessonPlanId.options[lessonPlanId.selectedIndex];
                if (selectedPlan.getAttribute('data-use_stripe') == 'false') {
                    const form = document.getElementById('register-form');
                    form.submit();
                    return;
                }

                // クレジットカード情報を取得
                const {paymentMethod, error} = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardNumber
                });

                if (error) {
                    alert('クレジットカード情報が正しくありません。');
                } else {
                    const form = document.getElementById('register-form');
                    const hiddenToken = document.createElement('input');
                    hiddenToken.setAttribute('type', 'hidden');
                    hiddenToken.setAttribute('value', paymentMethod.id);
                    hiddenToken.setAttribute('name', 'payment_token');
                    form.appendChild(hiddenToken);
                    form.submit();
                }
            });
        </script>
    @endif
@endsection
