<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規ユーザー登録完了通知</title>
    <style>
        table {
            border-collapse: collapse;
        }
        table tr th,
        table tr td {
            text-align: left;
            padding-left: 1em;
            padding-right: 1em;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <p>{{ $user->school->name }} 御中</p>
    <p>
        平素より大変お世話になっております。<br>
        {{ config('app.name') }}におきまして、以下のユーザーが新規登録されましたので、ご案内申し上げます。
    </p>

    <table>
        <tr>
            <th>カテゴリー</th>
            <td>{{ $user->role == 'teacher' ? '講師' : '生徒' }}</td>
        </tr>
        <tr>
            <th>氏名</th>
            <td>{{ $user->family_name }} {{ $user->first_name }} ({{ $user->family_name_kana }} {{ $user->first_name_kana }})</td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>{{ $user->tel }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>LINE ID</th>
            <td>{{ $user->line_id }}</td>
        </tr>
    </table>

    <p>以上、よろしくお願いいたします。</p>

    <p>※ このメールは、{{ config('app.name') }}より自動送信しております。</p>

    @include('emails.signature')

</body>
</html>
