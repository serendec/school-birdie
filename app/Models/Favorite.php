<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'video_category', 'video_category_id', 'video'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritable()
    {
        if ($this->video_category === 'lesson_record') {
            return $this->belongsTo(LessonRecord::class, 'video_category_id');
        } elseif ($this->video_category === 'video_advice') {
            return $this->belongsTo(VideoAdvice::class, 'video_category_id');
        }

        return null;
    }
}
