<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = ['page_id', 'section_id', 'section_type', 'data', 'sort_order', 'is_active'];

    protected $casts = [
        'data'      => 'array',
        'is_active' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    // Resolved data: inline data overrides the global section's data
    public function getResolvedDataAttribute(): array
    {
        if ($this->data) {
            return $this->data;
        }

        return $this->section?->data ?? [];
    }
}
