<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'template', 'meta_title', 'meta_description', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public function pageSections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    public function activeSections(): HasMany
    {
        return $this->pageSections()->where('is_active', true);
    }
}
