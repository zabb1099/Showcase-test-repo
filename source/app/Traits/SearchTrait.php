<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SearchTrait {

    public function scopeSearch(Builder $query, $search) : Builder
    {
        $attributes = $this->getSearchableColumns();

         return $query->where(function(Builder $query) use ($attributes, $search) {
            foreach ($attributes as $attribute) {
                $query->when(
                    str_contains($attribute, '.'),
                    function(Builder $query) use ($attribute, $search) {
                        [$relationName, $relationAttribute] = explode('.', $attribute);
                        $query->orWhereHas($relationName, function(Builder $query) use ($relationAttribute, $search) {
                            $query->where($relationAttribute, 'LIKE', "%{$search}%");
                        });
                    },
                    function(Builder $query) use ($attribute, $search) {
                        $query->orWhere($attribute, 'LIKE', "%{$search}%");
                    }
                );
            }
        });

    }
}
