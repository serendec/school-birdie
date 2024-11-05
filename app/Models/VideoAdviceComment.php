<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoAdviceComment extends Model
{
    use HasFactory, BySchoolIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'video_advice_id',
        'parent_comment_id',
        'mentioned_user_id',
        'user_id',
        'body'
    ];

    /**
     * リレーション
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function mentionedUser()
    {
        return $this->belongsTo(User::class, 'mentioned_user_id');
    }
    public function videoAdvice()
    {
        return $this->belongsTo(VideoAdvice::class);
    }
    public function parent()
    {
        return $this->belongsTo(VideoAdviceComment::class, 'parent_comment_id');
    }
    public function children()
    {
        return $this->hasMany(VideoAdviceComment::class, 'parent_comment_id');
    }

    /**
     * コメント削除時に通知も削除する
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($comment) {
            if ($comment->mentionedUser !== null){
                $comment->mentionedUser->notifications()
                        ->where('data->category', 'video_advice_comment')
                        ->where('data->comment_id', $comment->id)
                        ->delete();
            }
        });
    }

    /**
     * コメントを削除
     * 
     * @param int $commentId
     * @param int $schoolId
     * @return bool
     */
    public static function deleteComment(int $commentId, int $schoolId): bool
    {
        return self::whereHas('user', function ($query) use ($schoolId) {
                        $query->BySchoolId($schoolId);
                    })
                    ->find($commentId)
                    ->delete();
    }
}
