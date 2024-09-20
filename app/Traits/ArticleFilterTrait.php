<?php

namespace App\Traits;

trait ArticleFilterTrait
{
     /**
     * Apply category and tag filters to the Article query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  $category
     * @param  $tag
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ArticleFilter($query,$category , $tag)
    {
        // Apply category filter if provided
        if ($category) {
            $categoryFilter = $category;

            // Check if category is an array or a single value
            if (is_array($categoryFilter)) {
                $query->whereIn('category_id', $categoryFilter);
            } else {
                $query->where('category_id', $categoryFilter);
            }
        }

        // Apply tag filter if provided
        if ($tag) {
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->whereIn('tags.id', (array) $tag);
            });
        }

        return $query;
    }
}
