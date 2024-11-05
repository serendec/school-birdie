<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    // スクール一覧
    public function index()
    {
        $schools = School::all();
        return view('super_admin.index', compact('schools'));
    }

    // スクールの決済利用制限更新
    public function updateSchool(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'school_id'     => 'required|integer',
            'is_restricted' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return json_encode(['status' => 'error', 'message' => '不正なリクエストです']);
        }

        // スクールの取得
        $school = School::find($request->school_id);
        if (!$school) {
            return json_encode(['status' => 'error', 'message' => 'スクールが見つかりません']);
        }

        // 決済利用制限の更新
        $school->payment_restriction = $request->is_restricted;
        $school->save();

        return json_encode(['status' => 'success', 'message' => '決済利用制限を更新しました']);
    }
}
