<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function index()
    {
        $school = School::getSchoolInfoFromId(Auth::user()->school_id);
        return view('school.index', compact('school'));
    }

    public function edit()
    {
        $school = School::getSchoolInfoFromId(Auth::user()->school_id);
        return view('school.edit', compact('school'));
    }

    public function update(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'name'               => 'required|string|max:255',
            'url'                => 'string',
            'tel'                => 'required|max:13',
            'tel_available_time' => 'string|nullable',
            'email'              => 'string|max:255',
            'icon'               => 'image|mimes:png,jpg,jpeg|max:2048|nullable',
            'top_img'            => 'image|mimes:png,jpg,jpeg|max:2048|nullable'
        ])->validate();

        $school = School::updateFromRequest($request, Auth::user()->school_id);
        if (!$school){
            return redirect()->route('school.index')->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }

        // アイコン
        if ($request->hasFile('icon')){
            // 更新
            if ($school->icon) {
                Storage::disk('public')->delete('icons/' . Auth::user()->school_id . '/' . $school->icon);
            }
            $fileName = $request->file('icon')->store('icons/' . Auth::user()->school_id, 'public');
            $school->icon = basename($fileName);
            $school->save();
        } elseif ($request->input('clear_icon') == '1') {
            // クリア
            if ($school->icon) {
                Storage::disk('public')->delete('icons/' . Auth::user()->school_id . '/' . $school->icon);
                $school->icon = null;
                $school->save();
            }
        }

        // top画像
        if ($request->hasFile('top_img')){
            // 更新
            if ($school->top_img) {
                Storage::disk('public')->delete('img/' . Auth::user()->school_id . '/' . $school->top_img);
            }
            $fileName = $request->file('top_img')->store('img/' . Auth::user()->school_id, 'public');
            $school->top_img = basename($fileName);
            $school->save();
        } elseif ($request->input('clear_top_img') == '1') {
            // クリア
            if ($school->top_img) {
                Storage::disk('public')->delete('img/' . Auth::user()->school_id . '/' . $school->top_img);
                $school->top_img = null;
                $school->save();
            }
        }

        return redirect()->route('school.index')->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }
}
