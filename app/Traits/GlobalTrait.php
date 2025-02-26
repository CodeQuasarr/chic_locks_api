<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait GlobalTrait
{

    /**
     * @description Scope to filter data by field and value
     *
     * @param Builder $query
     * @param string $field
     * @param mixed $value
     * @return Builder
     */
    public function scopeFieldValue(Builder $query, string $field, mixed $value): Builder
    {
        if (is_array($value) || $value instanceof Collection) {
            return $query->whereIn($field, $value);
        }
        return $query->where($field, $value);
    }


}
