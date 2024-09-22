<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'category_id',
    ];

    public function tags() : BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }

    public function category() :BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function  scopeFcategory(Builder $query, $category): void{
        if(is_array($category)){
            $query->whereIn('category_id' , $category);
        }else{
            $query->where('category_id' , $category);
        }

    }

    public function scopeFtags(Builder $query, $tags): Void
    {
        $query->whereHas('tags', function (Builder $query) use ($tags) {
            if(is_array($tags)){
                $query->whereIn('tags.id', $tags);
            }else{
                $query->whereIn('tags.id', (array)$tags);
            }
        });
    }
}
