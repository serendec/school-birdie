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
        'register_teacher_token'
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
        $school->save();

        return $school;
    }
}
