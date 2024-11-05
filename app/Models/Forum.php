<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Forum extends Model
{
    use HasFactory, BySchoolIdTrait;

    protected $fillable = [
        'school_id', 'user_id', 'title', 'content', 'images'
    ];

    /**
     * リレーション
     *
     * @return void
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'forum_tag')->withTimestamps();
    }
    public function likes()
    {
        return $this->hasMany(ForumLike::class);
    }
    public function comments()
    {
        return $this->hasMany(ForumComment::class)->orderBy('created_at', 'desc');
    }

    /**
     * スクールのページネーション付きトピックを取得
     * 
     * @param int $school_id
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function getPaginatedList(int $school_id, int $perPage = 10): ?LengthAwarePaginator
    {
        return self::with('user:id,family_name,first_name,school_id,icon')
                    ->whereHas('user', function ($query) use ($school_id) {
                        $query->bySchoolId($school_id);
                    })
                    ->orderby('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * スクールのページネーション付きトピックを検索
     * 
     * @param int $school_id
     * @param Request $request
     * @param array $unreadLessonRecordIds
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function searchPaginatedList(int $school_id, Request $request, array $unreadLessonRecordIds = [], int $perPage = 10): ?LengthAwarePaginator
    {
        $list = self::with([
                        'tags',
                        'user:id,family_name,first_name,school_id,icon'
                    ])
                    ->whereHas('user', function ($query) use ($school_id) {
                        $query->bySchoolId($school_id);
                    });

        // 絞り込み
        // タイトル
        if ($request->filled('title')) {
            $list->where('title', 'like', "%{$request->title}%");
        }
        // タグ
        if ($request->has('tag_ids') && !empty($request->tag_ids)) {
            $list->whereHas('tags', function ($query) use ($request) {
                foreach ($request->tag_ids as $tagId) {
                    $query->where('tags.id', $tagId);
                }
            });
        }
        // 期間
        if ($request->filled('from')) {
            $list->where('created_at', '>=', $request->from.' 00:00:00');
        }
        if ($request->filled('to')) {
            $list->where('created_at', '<=', $request->to.' 23:59:59');
        }
        // 作成者
        if ($request->filled('user_id')) {
            $list->where('user_id', $request->user_id);
        }
        // 未読通知がある
        if ($request->filled('unread')) {
            $list->whereIn('id', $unreadLessonRecordIds);
        }

        return $list->orderby('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * スクールの直近3件のトピックを取得
     * 
     * @param int $school_id
     * @return Collection|null
     */
    public static function getLatestList(int $school_id): ?Collection
    {
        return self::with([
                        'user:id,family_name,first_name,school_id,icon',
                        'tags:name'
                    ])
                    ->withCount('comments')
                    ->whereHas('user', function ($query) use ($school_id) {
                        $query->bySchoolId($school_id);
                    })
                    ->orderby('created_at', 'desc')
                    ->limit(3)
                    ->get();
    }

    /**
     * トピックを取得
     *
     * @param int $id
     * @param int $school_id
     * @return Forum|null
     */
    public static function getContent(int $id, int $school_id): ?Forum
    {
        return self::BySchoolId($school_id)->findOrFail($id);
    }

    /**
     * トピックをコメントやいいねと共に取得
     *
     * @param int $id
     * @param int $school_id
     * @return Forum|null
     */
    public static function getContentWithComments(int $id, int $school_id): ?Forum
    {
        return self::with(['comments' => function ($query) {
            $query->withCount('likes');
        }, 'comments.children' => function ($query) {
            $query->withCount('likes');
        }])
        ->withCount('likes')
        ->BySchoolId($school_id)
        ->findOrFail($id);
    }

    /**
     * トピックの作成
     *
     * @param Request $request
     * @param User $user
     * 
     * @return Forum
     */
    public static function createWithTags(Request $request, User $user): Forum
    {
        $forum = new self([
            'school_id'  => $user->school_id,
            'user_id'    => $user->id,
            'title'      => $request->title,
            'content'    => $request->content,
        ]);
        $forum->save();

        if (!empty($request->tag_ids)) {
            $forum->tags()->attach($request->tag_ids);
        }

        return $forum;
    }

    /**
     * トピックの更新
     *
     * @param Request $request
     * @return Forum
     */
    public static function updateWithTags(Request $request) : Forum {
        $forum = self::find($request->id);
        $forum->title = $request->title;
        $forum->content = $request->content;
        $forum->save();
        $forum->tags()->sync($request->tag_ids);

        return $forum;
    }
}
