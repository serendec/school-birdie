<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory, BySchoolIdTrait;

    protected $fillable = [
        'name', 'school_id', 'display_order'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * カテゴリ毎の講座一覧を取得
     *
     * @param int $school_id
     * @param string $role
     * @return Collection|null
     */
    public static function getAllCoursesGroupedByCategory(int $school_id, string $role): ?Collection
    {
        return self::with(['courses' => function ($query) use ($role) {
                        if ($role === 'student') {
                            $query->where('post_status', 'publish');
                        }            
                        $query->orderBy('display_order');
                    }])
                    ->BySchoolId($school_id)
                    ->orderBy('display_order')
                    ->get();
    }

    /**
     * 全カテゴリ取得
     *
     * @param int $school_id
     * @return Collection|null
     */
    public static function getAllCategories(int $school_id): ?Collection
    {
        return self::BySchoolId($school_id)->orderBy('display_order')->get();
    }

    /**
     * カテゴリを作成
     *
     * @param int $school_id
     * @param string $name
     * @return boolean
     */
    public static function createFromRequest(int $school_id, string $name): bool
    {
        $display_order = self::BySchoolId($school_id)->count() + 1;
        $category = new self();
        $category->school_id = $school_id;
        $category->name = $name;
        $category->display_order = $display_order;
        return $category->save();
    }

    /**
     * 講座カテゴリ表示順を更新
     *
     * @param array $categoryIds
     * @return void
     */
    public static function updateOrder(array $categoryIds)
    {
        foreach ($categoryIds as $index => $categoryId) {
            $category = self::findOrFail($categoryId);
            $category->display_order = $index + 1;
            $category->save();
        }
    }
}
