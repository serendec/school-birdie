<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumLike extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'forum_id',
    ];

    /**
     * リレーション
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    /**
     * トピックにいいねしたかチェック
     * 
     * @param int $userId
     * @param int $forumId
     * @return self|null
     */
    public static function checkLiked(int $userId, int $forumId): ?self
    {
        return self::where('user_id', $userId)->where('forum_id', $forumId)->first();
    }
}
