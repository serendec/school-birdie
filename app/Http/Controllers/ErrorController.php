<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    private $serviceCategory = [
        'course'        => '講座',
        'forum'         => 'フォーラム',
        'lesson_record' => 'レッスン記録',
        'video_advice'  => '動画添削'
    ];

    public function notAvailable()
    {
        $category = 'ご選択のサービス';
        if (session('serviceName')){
            $category = $this->serviceCategory[session('serviceName')];
        }
        return view('error.not_available', compact('category'));
    }
}
