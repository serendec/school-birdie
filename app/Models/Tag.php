<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, BySchoolIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'name'
    ];

    /**
     * リレーション
     *
     * @return void
     */
    public function lessonRecords()
    {
        return $this->belongsToMany(LessonRecord::class, 'lesson_record_tag')->withTimestamps();
    }
    public function forums()
    {
        return $this->belongsToMany(Forum::class, 'forum_tag')->withTimestamps();
    }

    /**
     * 全タグを取得
     *
     * @param int $schoolId
     * @return Collection|null
     */
    public static function getTags(int $schoolId): ?Collection
    {
        return self::bySchoolId($schoolId)->get();
    }

    /**
     * 全タグを取得（idをキーにした配列）
     *
     * @param int $schoolId
     * @return array
     */
    public static function getTagsKeyId(int $schoolId) : array
    {
        $tags = self::bySchoolId($schoolId)->get();
        $tagsKeyId = [];
        foreach ($tags as $tag) {
            $tagsKeyId[$tag->id] = $tag->name;
        }
        return $tagsKeyId;
    }

    /**
     * タグ情報取得
     *
     * @param int $tagId
     * @param int $schoolId
     * @return Tag|null
     */
    public static function getTagById(int $tagId, int $schoolId): ?Tag
    {
        return self::bySchoolId($schoolId)
                    ->where('id', $tagId)
                    ->first();
    }

    /**
     * タグのランキングを取得
     *
     * @param int $schoolId
     * @param int $limit
     * @return Collection|null
     */
    public static function getTagRanking(int $schoolId, int $limit=5): ?Collection
    {
        return Tag::withCount(['forums' => function ($query) use ($schoolId) {
                $query->bySchoolId($schoolId);
            }])
            ->having('forums_count', '>', 0)
            ->orderBy('forums_count', 'desc')
            ->limit($limit)
            ->get();
    }
}
