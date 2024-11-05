<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::getAllCategories(Auth::user()->school_id);
        return view('course_category.index', compact('categories'));
    }

    public function create()
    {
        return view('course_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $courseCategory = CourseCategory::createFromRequest(Auth::user()->school_id, $request->name);
        if (!$courseCategory){
            return redirect()->route('course_category.index')->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }

        return redirect()->route('course_category.index')->with([
            'result' => 'success',
            'msg'    => __('messages.created_success')
        ]);
    }

    public function edit(Request $request)
    {
        $category = CourseCategory::BySchoolId($request->user()->school_id)->find($request->id);
        return view('course_category.edit', compact('category'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = CourseCategory::BySchoolId($request->user()->school_id)->find($request->id);
        $category->update($request->only('name'));

        return redirect()->route('course_category.index')->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }

    public function delete(Request $request)
    {
        $school_id = Auth::user()->school_id;
        $category = CourseCategory::BySchoolId($school_id)->find($request->id);
        $deletedDisplayOrder = $category->display_order;
        $category->delete();

        // 欠番が出るので、display_orderを詰める
        CourseCategory::where('school_id', $school_id)
                        ->where('display_order', '>', $deletedDisplayOrder)
                        ->update(['display_order' => DB::raw('display_order - 1')]);

        return redirect()->route('course_category.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }

    public function updateOrderIndex()
    {
        $categories = CourseCategory::getAllCategories(Auth::user()->school_id);
        return view('course_category.update_order', compact('categories'));
    }

    public function updateOrder(Request $request)
    {
        // バリデーション
        $school_id = Auth::user()->school_id;
        $request->validate([
            'categoryIds.*' => [
                'required',
                'integer',
                'exists:course_categories,id',
                Rule::exists('course_categories', 'id')->where('school_id', $school_id),
            ]
        ]);

        // コースの表示順を更新
        CourseCategory::updateOrder($request->categoryIds);

        return new JsonResponse([
            'message' => 'Order updated successfully.'
        ]);
    }
}
