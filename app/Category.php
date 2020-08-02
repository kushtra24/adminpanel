<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{

    /**
     * Many to many with article
     * @return BelongsToMany
     */
    public function article() {
        return $this->belongsToMany(Article::class, 'category_article');
    }
}
