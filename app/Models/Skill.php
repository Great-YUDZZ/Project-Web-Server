<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'level',
    ];

    protected $casts = [
        'level' => 'integer',
    ];

    public function scopeCategory($query, $category)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }

        return $query;
    }

    public function getCategoryBadgeColorAttribute(): string
    {
        return match ($this->category) {
            'networking' => 'border-cyan-500/30 text-cyan-400 bg-cyan-950/40',
            'sysadmin' => 'border-emerald-500/30 text-emerald-400 bg-emerald-950/40',
            'hardware' => 'border-amber-500/30 text-amber-400 bg-amber-950/40',
            'tools' => 'border-purple-500/30 text-purple-400 bg-purple-950/40',
            default => 'border-slate-500/30 text-slate-400 bg-slate-900/40',
        };
    }
}
