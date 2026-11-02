<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = ['name', 'type', 'data', 'is_active'];

    protected $casts = [
        'data'      => 'array',
        'is_active' => 'boolean',
    ];

    public function pageSections(): HasMany
    {
        return $this->hasMany(PageSection::class);
    }
}
