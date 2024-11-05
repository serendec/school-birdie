<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::getPaginatedList(Auth::user()->school_id);
        return view('teacher.index', compact('teachers'));
    }

    public function search(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'name'            => ['nullable', 'string'],
            'tel'             => ['nullable', 'string'],
            'email'           => ['nullable', 'string'],
            'main_teacher_id' => ['nullable', 'integer', 'min:1'],
            'sub_teacher_id'  => ['nullable', 'integer', 'min:1'],
            'inactive'        => ['nullable', 'in:1'],
        ])->validate();

        $teachers = Teacher::searchPaginatedList(Auth::user()->school_id, $request);

        // 絞り込み条件数を取得
        $filteredCount = 0;
        foreach ($request->all() as $key => $value) {
            if ($key != 'page' && $value !== null && $value !== '') {
                $filteredCount++;
            }
        }

        return view('teacher.index', compact('teachers', 'filteredCount'));
    }

    public function show(Request $request)
    {
        $teacher = Teacher::getTeacherInfoFromId($request->id, Auth::user()->school_id);
        if (empty($teacher)){
            return redirect()->route('teacher.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }

        return view('teacher.show', compact('teacher'));
    }

    public function edit(Request $request)
    {
        $teacher = Teacher::getTeacherInfoFromId($request->id, Auth::user()->school_id);

        // ポリシーによるアクセス制限
        $this->authorize('update', $teacher);

        return view('teacher.edit', compact('teacher'));
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'family_name'      => ['required', 'string', 'max:255'],
            'first_name'       => ['required', 'string', 'max:255'],
            'family_name_kana' => ['required', 'string', 'max:255'],
            'first_name_kana'  => ['required', 'string', 'max:255'],
            'icon'             => ['image', 'mimes:png,jpg,jpeg', 'max:2048', 'nullable'],
            'tel'              => ['required', 'string', 'max:13'],
            'id'               => ['required', 'integer'],
            'line_id'          => ['string', 'max:255', 'nullable'],
            'email'            => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($request->id),
            ],
        ])->validate();

        $teacher = Teacher::getTeacherInfoFromId($request->id, Auth::user()->school_id);
        if ($teacher == null){
            return redirect()->route('teacher.index')->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }

        // ポリシーによるアクセス制限
        $this->authorize('update', $teacher);

        // 新規画像の投稿があり、既存のアイコン画像があれば削除
        if ($request->file('icon')){
            if ($teacher->icon) {
                Storage::disk('public')->delete('icons/' . Auth::user()->school_id . '/' . $teacher->icon);
            }
            $fileName = $request->file('icon')->store('icons/' . Auth::user()->school_id, 'public');
            $teacher->icon = basename($fileName);

        // アイコンをクリアする場合
        } elseif ($request->input('clear_icon') == '1') {
            if ($teacher->icon) {
                Storage::disk('public')->delete('icons/' . Auth::user()->school_id . '/' . $teacher->icon);
                $teacher->icon = null;
            }
        }

        foreach ($request->except('id', 'icon', '_method', '_token') as $key => $value) {
            $teacher->$key = $value;
        }
        $teacher->save();

        return redirect()->route('teacher.show', $request->id)->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }

    public function showQrcode()
    {
        $schoolToken = School::getTokenFromSchoolId(Auth::user()->school_id);
        return view('teacher.qrcode', compact('schoolToken'));
    }

    public function delete(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:users,id'
            ],
        ]);
        
        $teacher = Teacher::getTeacherInfoFromId($request->id, Auth::user()->school_id);
        if (empty($teacher)){
            return redirect()->route('teacher.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }
        // $this->authorize('delete', $teacher);

        $teacher->delete();

        return redirect()->route('teacher.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }
}
