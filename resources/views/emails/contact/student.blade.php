@php
    $mainTeacher = $data['person_details']->teachers->where('category', 'main')->first() ?? null;
    $mainTeacherName = $mainTeacher ? $mainTeacher->family_name.' '.$mainTeacher->first_name : '未設定';
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>お問い合わせ</title>
</head>
<body>
    <p>{{ $data['school_name'] }} 御中</p>

    <p>
        平素より大変お世話になっております。<br>
        {{ config('app.name') }}におきまして、生徒様より以下の問い合わせがございました。<br>
        ご確認のほど、よろしくお願い申し上げます。
    </p>

    <p>[お問い合わせ者]</p>
    <ul>
        <li>お名前　　　　：{{ $data['person_details']['family_name'] . ' ' . $data['person_details']['first_name'] }} 様</li>
        <li>メールアドレス：{{ $data['person_details']['email'] }}</li>
        <li>メイン担当講師：{{ $mainTeacherName }} 様</li>
        <li>受講プラン　　：{{ $data['person_details']->studentProfile->lessonPlan->name ?? '未設定' }}</li>
        <li>生徒ページ　　：{{ route('student.show', $data['person_details']->id) }}</li>
    </ul>

    <p>[お問い合わせ内容]</p>
    <div>{!! nl2br(e($data['content'])) !!}</div>

    <p>
        ご不明な点ございましたら、ご連絡下さいませ。<br>
        よろしくお願い申し上げます。
    </p>

    @include('emails.signature')
</body>
</html>