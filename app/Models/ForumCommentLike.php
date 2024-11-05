<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCommentLike extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'forum_comment_id',
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
    public function forumComment()
    {
        return $this->belongsTo(ForumComment::class);
    }
}
