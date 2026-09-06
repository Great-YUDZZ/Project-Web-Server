<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'topology_image',
        'tools_used',
        'demo_link',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $baseSlug = Str::slug($project->title);
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $project->slug = $slug;
            }
        });
    }

    public function getToolsListAttribute(): array
    {
        if (empty($this->tools_used)) {
            return [];
        }

        return array_map('trim', explode(',', $this->tools_used));
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->topology_image) {
            if (Str::startsWith($this->topology_image, ['http://', 'https://', '/images/'])) {
                return $this->topology_image;
            }
            return asset('storage/' . $this->topology_image);
        }

        return asset('images/default-topology.svg');
    }
}
