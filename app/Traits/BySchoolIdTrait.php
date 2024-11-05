<?php

namespace App\Traits;

trait BySchoolIdTrait
{
    /**
     * スコープでschool_idを絞り込む
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $school_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySchoolId($query, $school_id)
    {
        return $query->where('school_id', $school_id);
    }
}
