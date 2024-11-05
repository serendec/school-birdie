<?php

namespace App\Http\Controllers;

use App\Models\LessonPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LessonPlanController extends Controller
{
    public function index()
    {
        // メイン講師情報を含んだ生徒リスト取得
        $lessonPlans = LessonPlan::getLessonPlans(Auth::user()->school_id);

        return view('lesson_plan.index', compact('lessonPlans'));
    }

    public function create()
    {
        return view('lesson_plan.create');
    }    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                                    => ['required', 'string', 'max:255'],
            'course_available'                        => ['required', 'integer', 'in:0,1'],
            'lesson_record_available'                 => ['required', 'integer', 'in:0,1'],
            'video_advice_available'                  => ['required', 'integer', 'in:0,1'],
            'video_advice_num'                        => ['nullable', 'integer', 'min:0'],
            'video_advice_automatically_close_period' => ['nullable', 'integer', 'min:0'],
            'forum_available'                         => ['required', 'integer', 'in:0,1'],
            'price'                                   => ['nullable', 'integer', 'min:0'],
            'stripe_plan_id'                          => ['nullable', 'string', 'max:255']
        ]);
        $validator->setAttributeNames([
            'name' => 'プラン名',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $lessonPlan = new LessonPlan();
        $lessonPlan->school_id = Auth::user()->school_id;
        $lessonPlan->fill($request->except('_token'));
        $lessonPlan->save();

        return redirect()->route('lesson_plan.index')->with([
            'result' => 'success',
            'msg'    => __('messages.created_success')
        ]);
    }    

    public function show(Request $request)
    {
        $lessonPlan = LessonPlan::getLessonPlan($request->id, Auth::user()->school_id);
        if (empty($lessonPlan)){
            return redirect()->route('lesson_plan.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }
        
        // 更新した場合のメッセージ
        $msg = (session('msg')) ? session('msg') : null;
        
        return view('lesson_plan.show', compact('lessonPlan', 'msg'));
    }

    public function edit(Request $request)
    {
        $lessonPlan = LessonPlan::getLessonPlan($request->id, Auth::user()->school_id);

        return view('lesson_plan.edit', compact('lessonPlan'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'                                      => ['required', 'integer', 'exists:lesson_plans,id'],
            'name'                                    => ['required', 'string', 'max:255'],
            'video_advice_available'                  => ['required', 'integer', 'in:0,1'],
            'video_advice_num'                        => ['nullable', 'integer', 'min:0'],
            'video_advice_automatically_close_period' => ['nullable', 'integer', 'min:0'],
            'course_available'                        => ['nullable', 'integer', 'in:0,1'],
            'lesson_record_available'                 => ['nullable', 'integer', 'in:0,1'],
            'forum_available'                         => ['nullable', 'integer', 'in:0,1'],
            'price'                                   => ['nullable', 'integer', 'min:0'],
            'stripe_plan_id'                          => ['nullable', 'string', 'max:255']
        ]);
        $validator->setAttributeNames([
            'name' => 'プラン名',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $lessonPlan = LessonPlan::getLessonPlan($request->id, Auth::user()->school_id);
        $lessonPlan->fill($request->except(['id', '_token', '_method']));
        $lessonPlan->save();

        return redirect(url('/lesson_plan/'.$request->id))->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }

    public function delete(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:lesson_plans,id',
                Rule::exists('lesson_plans', 'id')->where('school_id', Auth::user()->school_id),
            ],
        ]);

        $lessonPlan = LessonPlan::getLessonPlan($request->id, Auth::user()->school_id);
        $lessonPlan->delete();

        return redirect()->route('lesson_plan.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }
}
