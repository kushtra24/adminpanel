<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{

    protected $fillable = [ 'user_id', 'title', 'slug', 'content', 'photo', 'public'];

    /**
     * belongs to user
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * many to many with category
     * @return BelongsToMany
     */
    public function category() {
        return $this->belongsToMany(Category::class, 'category_article');
    }
}
