<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Student extends User
{
    protected $table = 'users';

    /**
     * Get the student and teacher relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'student_teacher_relations', 'student_id', 'teacher_id')
                    ->orderBy('family_name_kana')
                    ->orderBy('first_name_kana');
    }

    public function studentTeacherRelation()
    {
        return $this->hasMany(StudentTeacherRelation::class, 'student_id');
    }

    /**
     * Get the lesson record associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function lessonRecords()
    {
        return $this->hasMany(LessonRecord::class, 'student_id');
    }

    /**
     * Get the video advice data associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videoAdviceList()
    {
        return $this->hasMany(VideoAdvice::class, 'student_id');
    }

    /**
     * Get the student profile associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class, 'user_id');
    }

    /**
     * 生徒情報取得
     *
     * @param int $userId
     * @param int $schoolId
     * @return User|null
     */
    public static function getStudentInfoFromId(int $userId, int $schoolId): ?User
    {
        return self::with([
                        'teachers:id,family_name,first_name,nickname,student_teacher_relations.category,icon',
                        'studentProfile.lessonPlan'
                    ])
                    ->bySchoolId($schoolId)
                    ->where('users.id', $userId)
                    ->where('role', 'student')
                    ->first();
    }

    /**
     * 在籍生徒一覧取得
     *
     * @param int $schoolId
     * @return Collection|null
     */
    public static function getStudents(int $schoolId): ?Collection
    {
        return self::bySchoolId($schoolId)
                    ->where('role', 'student')
                    ->where('active', '1')
                    ->orderBy('family_name_kana')
                    ->orderBy('first_name_kana')
                    ->get();
    }

    /**
     * メイン講師の情報を含めた在籍生徒一覧取得
     *
     * @param int $schoolId
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function getPaginatedListWithMainTeacher(int $schoolId, int $perPage = 10): ?LengthAwarePaginator
    {
        return self::with('teachers:family_name,first_name,student_teacher_relations.category,icon')
                    ->bySchoolId($schoolId)
                    ->where('role', 'student')
                    ->where('active', '1')
                    ->orderBy('family_name_kana')
                    ->orderBy('first_name_kana')
                    ->paginate($perPage);
    }

    /**
     * メイン講師の情報を含めた生徒一覧検索
     *
     * @param int $schoolId
     * @param Request $request
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function searchPaginatedListWithMainTeacher(int $schoolId, Request $request, int $perPage = 10): ?LengthAwarePaginator
    {
        $list = self::with('teachers:id,family_name,first_name,student_teacher_relations.category,icon')
                    ->bySchoolId($schoolId)
                    ->where('role', 'student');

        // 絞り込み
        if ($request->filled('name')) {
            $list->where(function ($query) use ($request) {
                $query->where('family_name', 'like', "%{$request->name}%")
                    ->orWhere('first_name', 'like', "%{$request->name}%")
                    ->orWhere('family_name_kana', 'like', "%{$request->name}%")
                    ->orWhere('first_name_kana', 'like', "%{$request->name}%");
            });
        }
        if ($request->filled('nickname')) {
            $list->where('nickname', 'like', "%{$request->nickname}%");
        }
        if ($request->filled('tel')) {
            $list->where('tel', 'like', "%{$request->tel}%");
        }
        if ($request->filled('email')) {
            $list->where('email', 'like', "%{$request->email}%");
        }
        if ($request->filled('inactive')) {
            $list->where('active', '0');
        } else {
            $list->where('active', '1');
        }
        if ($request->filled('main_teacher_id')) {
            $list->whereHas('teachers', function ($query) use ($request) {
                $query->where('teacher_id', $request->main_teacher_id)
                      ->where('student_teacher_relations.category', 'main');
            });
        }
        if ($request->filled('sub_teacher_id')) {
            $list->whereHas('teachers', function ($query) use ($request) {
                $query->where('teacher_id', $request->sub_teacher_id)
                      ->where('student_teacher_relations.category', 'sub');
            });
        }
        
        return $list->orderBy('family_name_kana')
                    ->orderBy('first_name_kana')
                    ->paginate($perPage);
    }    

    /**
     * 在籍生徒名一覧取得
     *
     * @param int $schoolId
     * @return array<int, string>|[] キー：生徒のユーザーID、値：生徒名
     */
    public function getStudentsNameKeyUserId(int $schoolId): array
    {
        $students = $this->getStudents($schoolId);
        $studentNames = [];
        foreach ($students as $student) {
            $studentNames[$student->id] = $student->name;
        }
        return $studentNames;
    }
}