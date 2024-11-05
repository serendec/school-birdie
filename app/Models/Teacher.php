<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Teacher extends User
{
    protected $table = 'users';

    /**
     * リレーション
     *
     * @return void
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_teacher_relations', 'teacher_id', 'student_id');
    }
    public function lessonRecords()
    {
        return $this->hasMany(LessonRecord::class, 'teacher_id');
    }

    /**
     * トークンから講師情報を取得
     *
     * @param string $token
     * @return User|null
     */
    public static function getTeacherInfoFromToken(string $token): ?User
    {
        return self::where('register_student_token', $token)
                    ->first();
    }

    /**
     * 講師情報取得
     *
     * @param int $user_id
     * @param int $school_id
     * @return User|null
     */
    public static function getTeacherInfoFromId(int $user_id, int $school_id): ?User
    {
        return self::with('students:student_teacher_relations.category')
                    ->bySchoolId($school_id)
                    ->where('id', $user_id)
                    ->where(function($query){
                        $query->where('role', 'teacher')
                            ->orWhere('role', 'admin');
                    })
                    ->first();
    }

    /**
     * 在籍講師一覧のみ取得
     *
     * @param int $schoolId
     * @return Collection|null
     */
    public static function getTeachers(int $schoolId): ?Collection
    {
        return self::bySchoolId($schoolId)
                    ->where(function($query){
                        $query->where('role', 'teacher')
                            ->orWhere('role', 'admin');
                    })
                    ->where('active', '1')
                    ->orderBy('family_name_kana')
                    ->orderBy('first_name_kana')
                    ->get();
    }

    /**
     * 担当生徒情報と共に在籍講師一覧取得
     *
     * @param int $school_id
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function getPaginatedList(int $school_id, int $perPage = 10): ?LengthAwarePaginator
    {
        return self::with('students:student_teacher_relations.category')
                    ->bySchoolId($school_id)
                    ->where(function($query){
                        $query->where('role', 'teacher')
                            ->orWhere('role', 'admin');
                    })
                    ->where('active', '1')
                    ->orderBy('family_name_kana')
                    ->orderBy('first_name_kana')
                    ->paginate($perPage);
    }

    /**
     * 担当生徒情報と共に在籍講師一覧検索
     *
     * @param int $school_id
     * @param Request $request
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function searchPaginatedList(int $school_id, Request $request, int $perPage = 10): ?LengthAwarePaginator
    {
        $list = self::with('students:student_teacher_relations.category')
                    ->bySchoolId($school_id)
                    ->where(function($query){
                        $query->where('role', 'teacher')
                            ->orWhere('role', 'admin');
                    });
        
        // 絞り込み
        if ($request->filled('name')) {
            $list->where(function($query) use ($request){
                $query->where('family_name', 'like', '%'.$request->name.'%')
                    ->orWhere('first_name', 'like', '%'.$request->name.'%')
                    ->orWhere('family_name_kana', 'like', '%'.$request->name.'%')
                    ->orWhere('first_name_kana', 'like', '%'.$request->name.'%');
            });
        }
        if ($request->filled('tel')) {
            $list->where('tel', 'like', "%{$request->tel}%");
        }
        if ($request->filled('email')) {
            $list->where('email', 'like', '%'.$request->email.'%');
        }
        if ($request->filled('inactive')) {
            $list->where('active', '0');
        } else {
            $list->where('active', '1');
        }

        return $list->orderBy('family_name_kana')
                    ->orderBy('first_name_kana')
                    ->paginate($perPage);
    }    

    /**
     * 在籍講師名一覧取得
     *
     * @param int $school_id
     * @return array<int, string>|[] キー：講師のユーザーID、値：講師名
     */
    public function getTeachersNameKeyUserId(int $school_id): array
    {
        $teachers = $this->getPaginatedList($school_id, 0);
        $teachers_name = [];
        foreach ($teachers as $teacher) {
            $teachers_name[$teacher->id] = $teacher->name;
        }
        return $teachers_name;
    }

}