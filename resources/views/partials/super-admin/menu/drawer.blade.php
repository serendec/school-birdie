<div class="drawer-nav" id="drawer-content">
    <div class="drawer-menu">
        {{-- <div class="drawer-menu-content">
            <div class="mtbox">
                <div class="hd-2">設定</div>
                <nav class="listmenu">
                    <ul>
                        <li>
                            <a href="{{ route('password.edit') }}" class="button button-secondary width-full">
                                <span class="text">パスワード変更</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div> --}}
        <div class="drawer-menu-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="button button-thirdly">
                    <span class="text">ログアウト</span>
                    <span class="material-symbols-outlined"> logout </span>
                </button>
            </form>
        </div>
    </div>
</div>
