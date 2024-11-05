<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, BySchoolIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'family_name',
        'first_name',
        'family_name_kana',
        'first_name_kana',
        'nickname',
        'icon',
        'tel',
        'email',
        'line_id',
        'role',
        'school_id',
        'active',
        'register_student_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'register_student_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at'       => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
    ];

    /**
     * Get the forum comment likes associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function forumCommentLikes()
    {
        return $this->hasMany(ForumCommentLike::class);
    }

    /**
     * Get the course comment likes associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function courseCommentLikes()
    {
        return $this->hasMany(CourseCommentLike::class);
    }

    /**
     * Get the forum likes associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function forumLikes()
    {
        return $this->hasMany(ForumLike::class);
    }

    /**
     * Determine if the user has liked a specific forum comment.
     *
     * @param  int  $forumCommentId
     * @return bool
     */
    public function hasLikedForumComment($forumCommentId)
    {
        return $this->forumCommentLikes()->where('forum_comment_id', $forumCommentId)->exists();
    }

    /**
     * Determine if the user has liked a specific course comment.
     *
     * @param  int  $courseCommentId
     * @return bool
     */
    public function hasLikedCourseComment($courseCommentId)
    {
        return $this->courseCommentLikes()->where('course_comment_id', $courseCommentId)->exists();
    }

    /**
     * Get the school details associated with the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the course progress data associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function UserCourseProgress()
    {
        return $this->hasMany(UserCourseProgress::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * スクールの全ユーザー取得
     * 
     * @param int $school_id
     * @return Collection|null
     */
    public static function getSchoolUsers(int $school_id) : ?Collection
    {
        return self::where('school_id', $school_id)->get();
    }
}
