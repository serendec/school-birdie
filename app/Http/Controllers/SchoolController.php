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
            'url'                => 'string|nullable',
            'tel'                => 'required|max:13',
            'tel_available_time' => 'string|nullable',
            'email'              => 'string|max:255|nullable',
            'icon'               => 'image|mimes:png,jpg,jpeg|max:2048|nullable',
            'top_img'            => 'image|mimes:png,jpg,jpeg|max:2048|nullable',
            'tokushoho_company_name' => 'string|max:255|nullable',
            'tokushoho_address' => 'string|nullable',
            'tokushoho_tel' => 'string|nullable',
            'tokushoho_email' => 'string|max:255|nullable',
            'tokushoho_representative' => 'string|max:255|nullable',
            'tokushoho_additional_fees' => 'string|nullable',
            'tokushoho_refund_policy' => 'string|nullable',
            'tokushoho_delivery_time' => 'string|nullable',
            'tokushoho_payment_method' => 'string|nullable',
            'tokushoho_payment_period' => 'string|nullable',
            'tokushoho_price' => 'string|nullable',
            'tokushoho_validity_period' => 'string|nullable',
            'tokushoho_sales_quantity' => 'string|nullable',
            'tokushoho_usage_method' => 'string|nullable'
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

    public function contract()
    {
        // 契約プラン
        $schoolId = Auth::user()->school_id;
        $schoolPlan = config("school.{$schoolId}") ? config("school.{$schoolId}")['plan'] : '未設定';

        //　使用容量
        $storageUsage = 0;
        $overStorage = false;
        if (Auth::user()->school->storage_usage && Auth::user()->school->storage_usage > 0){
            $storageUsage = Auth::user()->school->storage_usage;

            if (config("school.{$schoolId}")
                && config("school.{$schoolId}")['storage_limit'] > 0
                && Auth::user()->school->storage_usage > config("school.{$schoolId}")['storage_limit']){
                    $overStorage = true;
                }
        }

        return view('school.contract', compact('schoolPlan', 'storageUsage', 'overStorage'));
    }
}
