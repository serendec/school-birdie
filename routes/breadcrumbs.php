<?php
// routes/breadcrumbs.php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

/**
 * パンくず作成
 *
 * @param string $targetPage 対象のページ
 * @param string $destinationRoute 遷移先
 * @param string $title 表示タイトル
 * @return void
 */
function createBreadcrumb($targetPage, $destinationRoute, $title, $parameter = null) {
    Breadcrumbs::for($targetPage, function ($trail) use ($title, $destinationRoute, $parameter) {
        if ($parameter) {
            $trail->push($title, route($destinationRoute, $parameter));
            return;
        }
        $trail->push($title, route($destinationRoute));
    });
}

function createBreadcrumbForShowPage($category, $title) {
    Breadcrumbs::for($category.'.show', function ($trail) use ($category, $title) {
        $previousUrl = URL::previous();
        $destinationRoute = route($category.'.index');
        if (strpos($previousUrl, $category.'/search') !== false) {
            $destinationRoute = $previousUrl;
        }
        $trail->push($title, $destinationRoute);
    });
}

// 権限がないエラーページ
createBreadcrumb('not_available', 'home', 'ホーム');

// アカウント関連
createBreadcrumb('teacher.qrcode', 'teacher.index', '講師管理');
createBreadcrumb('student.qrcode', 'student.index', '生徒管理');
createBreadcrumb('mypage', 'home', 'ホーム');
createBreadcrumb('password.edit', 'home', 'ホーム');

// スクール情報
createBreadcrumb('school.index', 'home', 'ホーム');
createBreadcrumb('school.edit', 'school.index', 'スクール情報');
createBreadcrumb('school.contract', 'home', 'ホーム');

// お問い合わせ
createBreadcrumb('contact.create', 'home', 'ホーム');

// 生徒関連
if (Auth::user() && Auth::user()->role == 'student'){
    createBreadcrumb('student.show', 'home', 'ホーム');
    createBreadcrumb('student.edit', 'mypage', '編集キャンセル');
} else {
    createBreadcrumb('student.index', 'home', 'ホーム');
    createBreadcrumb('student.search', 'home', 'ホーム');
    createBreadcrumbForShowPage('student', '生徒管理');
    if (isset(request()->route()->id)){
        createBreadcrumb('student.edit', 'student.show', '編集キャンセル', request()->route()->id);
    } else {
        createBreadcrumb('student.edit', 'student.index', '生徒管理');
    }

    createBreadcrumb('student.download', 'home', 'CSVダウンロード');

}

// 講師関連
createBreadcrumb('teacher.index', 'home', 'ホーム');
createBreadcrumb('teacher.search', 'home', 'ホーム');
createBreadcrumbForShowPage('teacher', '講師管理');
if (isset(request()->route()->id)){
    if (request()->route()->id == Auth::user()->id){
        createBreadcrumb('teacher.edit', 'mypage', '個人設定');
    } else {
        createBreadcrumb('teacher.edit', 'teacher.show', '編集キャンセル', request()->route()->id);
    }
} else {
    createBreadcrumb('teacher.edit', 'teacher.index', '講師管理');
}

// 受講プラン関連
createBreadcrumb('lesson_plan.index', 'home', 'ホーム');
createBreadcrumb('lesson_plan.create', 'lesson_plan.index', '受講プラン');
createBreadcrumbForShowPage('lesson_plan', '受講プラン');
if (isset(request()->route()->id)){
    createBreadcrumb('lesson_plan.edit', 'lesson_plan.show', '編集キャンセル', request()->route()->id);
} else {
    createBreadcrumb('lesson_plan.edit', 'lesson_plan.index', '受講プラン');
}

// タグ関連
createBreadcrumb('tag.index', 'home', 'ホーム');
createBreadcrumb('tag.create', 'tag.index', 'タグ管理');
createBreadcrumb('tag.edit', 'tag.index', 'タグ管理');

// 動画添削関連
createBreadcrumb('video_advice.index', 'home', 'ホーム');
createBreadcrumb('video_advice.search', 'home', 'ホーム');
createBreadcrumb('video_advice.create', 'video_advice.index', '動画添削');
createBreadcrumbForShowPage('video_advice', '動画添削');
if (isset(request()->route()->id)){
    createBreadcrumb('video_advice.edit', 'video_advice.show', '編集キャンセル', request()->route()->id);
} else {
    createBreadcrumb('video_advice.edit', 'video_advice.index', '動画添削');
}

// ゴルフ講座関連
createBreadcrumb('course.index', 'home', 'ホーム');
createBreadcrumb('course.create', 'course.index', '講座');
createBreadcrumb('course.show', 'course.index', '講座');
if (isset(request()->route()->id)){
    createBreadcrumb('course.edit', 'course.show', '編集キャンセル', request()->route()->id);
} else {
    createBreadcrumb('course.edit', 'course.index', '講座');
}
createBreadcrumb('course.update_order_index', 'course.index', '講座');

// 講座カテゴリ関連
createBreadcrumb('course_category.index', 'home', 'ホーム');
createBreadcrumb('course_category.update_order_index', 'course_category.index', '講座カテゴリ');
createBreadcrumb('course_category.create', 'course_category.index', '講座カテゴリ');
createBreadcrumb('course_category.edit', 'course_category.index', '講座カテゴリ');

// レッスン記録関連
createBreadcrumb('lesson_record.index', 'home', 'ホーム');
createBreadcrumb('lesson_record.search', 'home', 'ホーム');
createBreadcrumb('lesson_record.create', 'lesson_record.index', 'レッスン記録');
createBreadcrumbForShowPage('lesson_record', 'レッスン記録');
if (isset(request()->route()->id)){
    createBreadcrumb('lesson_record.edit', 'lesson_record.show', '編集キャンセル', request()->route()->id);
} else {
    createBreadcrumb('lesson_record.edit', 'lesson_record.index', 'レッスン記録');
}

// フォーラム関連
createBreadcrumb('forum.index', 'home', 'ホーム');
createBreadcrumb('forum.search', 'home', 'ホーム');
createBreadcrumb('forum.create', 'forum.index', 'フォーラム');
createBreadcrumbForShowPage('forum', 'フォーラム');
if (isset(request()->route()->id)){
    createBreadcrumb('forum.edit', 'forum.show', '編集キャンセル', request()->route()->id);
} else {
    createBreadcrumb('forum.edit', 'forum.index', 'フォーラム');
}

// お気に入り動画
createBreadcrumb('favorite.index', 'home', 'ホーム');
