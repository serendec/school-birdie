@extends('layouts.app')

@section('content')
    <div class="imagebg"
    style="
        background-image: url(https://img.freepik.com/free-photo/golf-game_1204-328.jpg?w=2000);
    ">
        <div class="imagebg-gra">
            <div class="imagebg-gra-content">
                <h1 class="hd-1">{{ $category }}</h1>
            </div>
            <div class="empty">
                お申し込みの受講プランでは、{{ $category }}は利用できません。<br>
                ご利用については担当講師にご相談ください。
            </div>
        </div>
    </div>
@endsection
