@extends('layouts.app')

@section('content')
<div class="site-body-wrapper">
    <h1 class="hd-1">受講プラン</h1>

    <div class="listcontrol">
        <div class="listcontrol-left">
            <a href="{{ route('lesson_plan.create') }}" class="button button-primary">
                <span class="text">新規作成</span>
            </a>
        </div>
    </div>

    @if ($lessonPlans->isEmpty())
        <div class="empty">受講プランが登録されていません。</div>
    @else
        @foreach ($lessonPlans as $lessonPlan)
            <a class="card" href="{{ route('lesson_plan.show', $lessonPlan->id) }}">
                <span class="card-content">
                    <span class="card-name">
                        <span class="namebox">
                            {{ $lessonPlan->name }}
                        </span>
                    </span>
                </span>
                <span class="card-arrow">
                    <span class="material-symbols-outlined">
                        chevron_right
                    </span>
                </span>
            </a>
        @endforeach
    @endif
</div>
@endsection
