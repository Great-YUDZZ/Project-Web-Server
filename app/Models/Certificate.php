<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'issuer',
        'credential_id',
        'issued_date',
        'duration_hours',
        'verification_status',
        'description',
        'credential_url',
        'file_path',
        'order',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getFileUrlAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        if (Str::startsWith($this->file_path, ['http://', 'https://'])) {
            return $this->file_path;
        }

        if (Str::startsWith($this->file_path, ['/images/', 'images/', '/certificates/', 'certificates/'])) {
            return asset(ltrim($this->file_path, '/'));
        }

        return asset('storage/'.$this->file_path);
    }

    public function getIsPdfAttribute(): bool
    {
        if (! $this->file_path) {
            return false;
        }

        return Str::endsWith(strtolower($this->file_path), '.pdf');
    }

    public function getPreviewImageUrlAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        if (Str::endsWith(strtolower($this->file_path), ['.png', '.jpg', '.jpeg', '.webp', '.svg'])) {
            return $this->file_url;
        }

        if (Str::contains($this->file_path, 'modern-ai')) {
            return asset('certificates/cisco-modern-ai-preview-1.png');
        }

        if (Str::contains($this->file_path, ['networking-devices', 'devices'])) {
            return asset('certificates/cisco-networking-devices-preview-1.png');
        }

        if (Str::contains($this->file_path, ['networking-basics', 'cisco'])) {
            return asset('certificates/cisco-networking-basics-preview-1.png');
        }

        if (Str::contains($this->file_path, 'fiber-optic')) {
            return asset('certificates/fiber-optic-preview-1.png');
        }

        if (Str::contains($this->file_path, 'mindset-digital')) {
            return asset('certificates/mindset-digital-preview-1.png');
        }

        return null;
    }
}
