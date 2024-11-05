@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="editcase">
                            <div class="editcase-left">
                                <div class="namebox">
                                    @include('partials.icon', [
                                        'icon' => $student->icon,
                                        'size' => 'default',
                                    ])
                                    <div>
                                        <div class="text size-mini block">
                                            {{ $student->family_name_kana }}　{{ $student->first_name_kana }}
                                        </div>
                                        <h1 class="text size-default weight-normal ma-0">
                                            {{ $student->family_name }}　{{ $student->first_name }}
                                        </h1><br>
                                        <span class="text size-mini">ニックネーム：{{ $student->nickname }}</span>
                                    </div>
                                </div>
                            </div>
                            @can('isAdmin')
                                <div class="editcase-right">
                                    <a href="{{ route('student.edit', $student->id) }}" class="button button-secondary">
                                        <span class="text">編集</span>
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="detail-content">
                <div class="detail-content-header">連絡先</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">電話</div>
                        <div class="text size-middle block">
                            {{ $student->tel ?? '未設定' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">メール</div>
                        <div class="text size-middle block">
                            {{ $student->email ?? '未設定' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">LINE</div>
                        <div class="text size-middle block">
                            {{ $student->line_id ?? '未設定' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content">
                <div class="detail-content-header">受講プラン</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            @if (isset($student->studentProfile) && $student->studentProfile->lessonPlan != null)
                                {{ $student->studentProfile->lessonPlan->name }}
                            @else
                                未設定
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content">
                <div class="detail-content-header">直近決済状況</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            @if ($latestInvoice == null)
                                未設定
                            @else
                                <table class="stripe-payment-situation">
                                    <tr>
                                        <th>金額</th>
                                        <td>：</td>
                                        <td>{{ $latestInvoice->amount_due ? number_format($latestInvoice->amount_due).'円' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>ステータス</th>
                                        <td>：</td>
                                        <td>{{ $statusJapanese }}</td>
                                    </tr>
                                    <tr>
                                        <th>頻度</th>
                                        <td>：</td>
                                        <td>{{ $frequency }}</td>
                                    </tr>
                                    <tr>
                                        <th>請求書番号</th>
                                        <td>：</td>
                                        <td>{{ $latestInvoice->number }}</td>
                                    </tr>
                                    <tr>
                                        <th>作成日</th>
                                        <td>：</td>
                                        <td>{{ $createdDate }}</td>
                                    </tr>
                                </table>
                                <a href="{{ $latestInvoice->invoice_pdf }}" class="button button-secondary button-small" target="_blank" rel="noopener noreferrer">請求書ダウンロード</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content">
                <div class="detail-content-header">担当講師</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">メイン</div>
                        <div class="text size-middle block">
                            <span class="teacherlist">
                                <span class="teacherlist-main">
                                    <span class="namebox">
                                        @php
                                            $mainTeacher = $student->teachers->where('category', 'main')->first();
                                        @endphp
                                        @include('partials.icon', [
                                            'icon' => $mainTeacher->icon,
                                            'size' => 'small',
                                        ])
                                        <span>
                                            <span
                                                class="text size-small">{{ $mainTeacher->family_name }}　{{ $mainTeacher->first_name }}</span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">サブ</div>
                        <div class="text size-middle block">
                            <span class="teacherlist">
                                <span class="teacherlist-sub">
                                    @if ($student->teachers->where('category', 'sub')->isNotEmpty())
                                        @foreach ($student->teachers->where('category', 'sub') as $subTeacher)
                                            <span class="namebox">
                                                @include('partials.icon', [
                                                    'icon' => $subTeacher->icon,
                                                    'size' => 'small',
                                                ])
                                                <span class="text size-small">
                                                    {{ $subTeacher->family_name }}　{{ $subTeacher->first_name }}
                                                </span>
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="namebox">未設定</span>
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content {{ Auth::user()->role == 'admin' ? 'noedit' : '' }}">
                <div class="detail-content-header">登録日</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            {{ $student->created_at->format('Y/m/d') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
