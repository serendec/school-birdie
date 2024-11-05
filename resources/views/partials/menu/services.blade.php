<div class="welcome">
    <div class="welcome-message">
        <span class="text">ようこそ！</span>
    </div>
    <div class="welcome-avator">
        @include('partials.icon', ['icon' => Auth::user()->icon, 'size' => 'large'])
    </div>
    <div class="welcome-name">
        <div class="text">{{ Auth::user()->family_name }} {{ Auth::user()->first_name }}さん</div>
    </div>
</div>

<div class="mtbox">
    <nav class="main-navigation">
        <ul>
            <li>
                <a href="{{ route('lesson_record.index') }}" class="button button-secondary type-square">
                    <span class="content">
                        <span class="material-symbols-outlined">
                            history_edu
                        </span>
                        <span class="text">レッスン記録</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('video_advice.index') }}" class="button button-secondary type-square">
                    <span class="content">
                        <span class="material-symbols-outlined">
                            movie
                        </span>
                        <span class="text">動画添削</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('course.index') }}" class="button button-secondary type-square">
                    <span class="content">
                        <span class="material-symbols-outlined">
                            school
                        </span>
                        <span class="text">ゴルフ講座</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('forum.index') }}" class="button button-secondary type-square">
                    <span class="content">
                        <span class="material-symbols-outlined">
                            forum
                        </span>
                        <span class="text">フォーラム</span>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</div>
