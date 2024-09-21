<?php

namespace App\Traits;

trait ArticleFilterTrait
{
     /**
     * Apply category and tag filters to the Article query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  $category  allowed category
     * @param  $tag  allowed tag
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ArticleFilter($query,$category , $tag)
    {
        // Apply category filter if provided
        if ($category) {
            $query->fcategory( $category);
        }
        // Apply tag filter if provided
        if ($tag) {
            $query->ftags($tag);
        }
        return $query;
    }
}
