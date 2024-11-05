<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTeacherRelation extends Model
{
    use HasFactory, BySchoolIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'student_id',
        'category'
    ];

    // リレーション
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
    /**
     * メイン担当講師登録
     *
     * @param int $teacherId
     * @param int $user_id
     * @return void
     */
    public function registerMainTeacher(int $teacherId, int $user_id)
    {
        $data = new self();
        $data->teacher_id = $teacherId;
        $data->student_id = $user_id;
        $data->category = 'main';
        $data->save();
    }

    /**
     * 特定の講師が担当する全生徒リスト取得
     *
     * @param int $teacherId
     * @return Collection|null
     */
    public function getStudentsOfTeacher(int $teacherId): ?Collection
    {
        return self::with('student:id,family_name,first_name')
                    ->select('student_id', 'category')
                    ->where('teacher_id', $teacherId)
                    ->get();
    }

    /**
     * 講師と担当生徒の生データリスト取得
     *
     * @param int $schoolId
     * @return Collection|null
     */
    public function getStudentTeacherAllRelation(int $schoolId): ?Collection
    {
        return self::with('student:id,family_name,first_name', 'teacher:id,family_name,first_name')
                    ->select('teacher_id', 'student_id', 'category')
                    ->whereHas('student', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->whereHas('teacher', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->get();
    }

    /**
     * 講師と担当生徒の整形リスト取得
     *
     * @param int $schoolId
     * @return array<int teacher_id, array{main:int, sub:int}>
     */
    public function getStudentsInChargeNumbers(int $schoolId): array
    {
        $studentsOfTeachers = [];
        $studentTeacherAllList = $this->getStudentTeacherAllRelation($schoolId);
        foreach ($studentTeacherAllList as $studentTeacherList){
            if (!isset($studentsOfTeachers[$studentTeacherList->teacher_id])){
                $studentsOfTeachers[$studentTeacherList->teacher_id] = [
                    'main' => 0,
                    'sub'  => 0
                ];
            }
            $studentsOfTeachers[$studentTeacherList->teacher_id][$studentTeacherList->category] += 1;
        }

        return $studentsOfTeachers;
    }

    /**
     * メイン講師リストの取得
     *
     * @return array<int, array{student_id:int, teacher_id:int, teacher_name:string}>
     */
    // public function getMainTeacherRelation(): array
    // {
    //     $main_teacher_relation = [];
    //     $teacher_student_lists = $this->getTeacherStudentList();
    //     foreach ($teacher_student_lists as $teacher_student_list){
    //         if ($teacher_student_list->category == 'main'){
    //             $main_teacher_relation[] = [
    //                 'student_id' => $teacher_student_list->student_id,
    //                 'teacher_id' => $teacher_student_list->teacher_id,
    //                 'teacher_name'    => $teacher_student_list->teacher_name
    //             ];
    //         }
    //     }
    //     return $main_teacher_relation;
    // }

    /**
     * 指定した講師の担当生徒情報を取得
     *
     * @param int $teacherId
     * @param int $schoolId
     * @return Collection|null
     */
    public function getTeacherStudentListByTeacherId(int $teacherId, int $schoolId): ?Collection
    {
        return self::select('student_id', 'student_teacher_relations.category')
                    ->join('users', 'student_teacher_relations.teacher_id', 'users.id')
                    ->bySchoolId($schoolId)
                    ->where('teacher_id', $teacherId)
                    ->get();
    }

    /**
     * 指定した講師の担当生徒の整形リスト取得
     *
     * @param int $teacherId
     * @param int $schoolId
     * @return array
     */
    public function getStudentInChargeNumbers(int $teacherId, int $schoolId): array
    {
        $studentsOfTeacher = [
            'main' => 0,
            'sub'  => 0
        ];
        $students = $this->getTeacherStudentListByTeacherId($teacherId, $schoolId);
        foreach ($students as $student){
            $studentsOfTeacher[$student->category] += 1;
        }

        return $studentsOfTeacher;
    }

    /**
     * 指定した生徒の講師情報を取得
     *
     * @param int $studentId
     * @return Collection|null
     */
    public function getTeachersListByStudentId(int $studentId): ?Collection
    {
        return self::select('teacher_id', 'family_name', 'first_name', 'category')
                    ->join('users', 'student_teacher_relations.teacher_id', 'users.id')
                    ->where('student_id', $studentId)
                    ->get();
    }

    /**
     * 指定した生徒のメイン講師のUserIdを取得
     * 
     * @param int $studentId
     * @return int
     */
    public static function getMainTeacherId(int $studentId) : int
    {
        return self::where('student_id', $studentId)
                    ->where('category', 'main')
                    ->value('teacher_id');
    }
}
