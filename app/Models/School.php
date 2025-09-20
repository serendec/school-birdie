<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'url',
        'tel',
        'email',
        'icon',
        'top_img',
        'tel_available_time',
        'register_teacher_token',
        'tokushoho_company_name',
        'tokushoho_address',
        'tokushoho_tel',
        'tokushoho_email',
        'tokushoho_representative',
        'tokushoho_additional_fees',
        'tokushoho_refund_policy',
        'tokushoho_delivery_time',
        'tokushoho_payment_method',
        'tokushoho_payment_period',
        'tokushoho_price',
        'tokushoho_validity_period',
        'tokushoho_sales_quantity',
        'tokushoho_usage_method'
    ];

    /**
     * リレーション
     *
     * @return void
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function course_categories()
    {
        return $this->hasMany(CourseCategory::class);
    }

    /**
     * トークンからスクールIDを取得
     *
     * @param string $token
     * @return int|null
     */
    public static function getSchoolIdFromToken(string $token): ?int
    {
        return self::where('register_teacher_token', $token)
                    ->value('id');
    }

    /**
     * School IDからトークンを取得
     *
     * @param int $school_id
     * @return string|null
     */
    public static function getTokenFromSchoolId(int $school_id): ?string
    {
        return self::where('id', $school_id)
                    ->value('register_teacher_token');
    }

    /**
     * スクールIDからスクール情報を取得
     *
     * @param int $school_id
     * @return School|null
     */
    public static function getSchoolInfoFromId(int $school_id): ?School
    {
        return self::where('id', $school_id)->first();
    }

    /**
     * スクール情報を更新
     *
     * @param Request $request
     * @param int $school_id
     * @return School
     */
    public static function updateFromRequest(Request $request, int $school_id): self
    {
        $school = self::getSchoolInfoFromId($school_id);
        $school->name = $request->name;
        $school->url = $request->url;
        $school->tel = $request->tel;
        $school->tel_available_time = $request->tel_available_time;
        $school->email = $request->email;

        // 特商法関連の情報を更新
        $school->tokushoho_company_name = $request->tokushoho_company_name;
        $school->tokushoho_address = $request->tokushoho_address;
        $school->tokushoho_tel = $request->tokushoho_tel;
        $school->tokushoho_email = $request->tokushoho_email;
        $school->tokushoho_representative = $request->tokushoho_representative;
        $school->tokushoho_additional_fees = $request->tokushoho_additional_fees;
        $school->tokushoho_refund_policy = $request->tokushoho_refund_policy;
        $school->tokushoho_delivery_time = $request->tokushoho_delivery_time;
        $school->tokushoho_payment_method = $request->tokushoho_payment_method;
        $school->tokushoho_payment_period = $request->tokushoho_payment_period;
        $school->tokushoho_price = $request->tokushoho_price;
        $school->tokushoho_validity_period = $request->tokushoho_validity_period;
        $school->tokushoho_sales_quantity = $request->tokushoho_sales_quantity;
        $school->tokushoho_usage_method = $request->tokushoho_usage_method;

        $school->save();

        return $school;
    }
}
