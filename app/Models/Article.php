<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
