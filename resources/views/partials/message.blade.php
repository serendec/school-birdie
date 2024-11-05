@if (session('msg'))
    <div class="messagebox">
        <div class="message type-{{ session('result') ?? 'alert' }}">
            <div class="message-content">
                <span class="material-symbols-outlined">
                    @php
                        $result = 'error';
                        if (session('result')) {
                            $result = session('result') == 'success' ? 'done' : session('result');
                        }
                    @endphp
                    {{ $result }}
                </span>
                <span class="text size- block">{{ session('msg') }}</span>
            </div>
            <span class="material-symbols-outlined close-msg-btn"> close </span>
        </div>
    </div>
@elseif (count($errors) > 0)
    <div class="messagebox">
        <div class="message type-alert">
            <div class="message-content">
                <span class="material-symbols-outlined">
                    error
                </span>
                <span class="text size- block">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </span>
            </div>
            <span class="material-symbols-outlined close-msg-btn"> close </span>
        </div>
    </div>
@elseif (session('status') == "password-updated")
    <div class="messagebox">
        <div class="message type-success">
            <div class="message-content">
                <span class="material-symbols-outlined">
                    done
                </span>
                <span class="text size- block">
                    <p>パスワードを変更しました。</p>
                </span>
            </div>
            <span class="material-symbols-outlined close-msg-btn"></span>
        </div>
    </div>
@elseif ($errors->updatePassword->has('current_password') || $errors->updatePassword->has('password'))
    <div class="messagebox">
        <div class="message type-alert">
            <div class="message-content">
                <span class="material-symbols-outlined">
                    error
                </span>
                <span class="text size- block">
                    <ul>
                        @if ($errors->updatePassword->has('current_password'))
                            <li>{{ $errors->updatePassword->first('current_password') }}</li>
                        @endif
                        @if ($errors->updatePassword->has('password'))
                            <li>{{ $errors->updatePassword->first('password') }}</li>
                        @endif
                    </ul>
                </span>
            </div>
            <span class="material-symbols-outlined close-msg-btn"></span>
        </div>
    </div>
@endif
