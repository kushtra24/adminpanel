<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [ 'user_id', 'title', 'slug', 'content', 'photo', 'public'];

    /**
     * belongs to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * many to many with category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category() {
        return $this->belongsToMany(Category::class, 'category_article');
    }
}
