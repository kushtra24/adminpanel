<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * Many to many with article
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function article() {
        return $this->belongsToMany(Article::class, 'category_article');
    }
}
