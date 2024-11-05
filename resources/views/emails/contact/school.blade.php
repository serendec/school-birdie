<!DOCTYPE html>
<html>
<head>
    <title>お問い合わせ</title>
</head>
<body>
    <p>
        {{ config('app.name') }}から以下の問い合わせがございました。<br>
        内容ご確認の上、ご対応をお願いいたします。
    </p>

    <p>[お問い合わせ者]</p>
    <ul>
        <li>所属スクール　：{{ $data['school_name'] }}</li>
        <li>お名前　　　　：{{ $data['person_details']['family_name'] . ' ' . $data['person_details']['first_name'] }} 様</li>
        <li>権限　　　　　：{{ $data['person_details']['role'] == 'admin' ? '管理者' : '講師' }}</li>
        <li>メールアドレス：{{ $data['person_details']['email'] }}</li>
    </ul>

    <p>[お問い合わせ内容]</p>
    <div>{!! nl2br(e($data['content'])) !!}</div>
</body>
</html>