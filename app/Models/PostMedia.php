<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PostMedia extends Model
{
    use HasFactory;

    protected $table = 'post_media';

    protected $fillable = [
        'post_id',
        'temp_token',
        'file_path',
        'file_name',
        'media_type',
        'mime_type',
        'file_size',
        'caption',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'file_size' => 'integer',
    ];

    protected $appends = [
        'url',
        'markdown_tag',
        'formatted_size',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * URL publik untuk akses berkas atau tautan embed.
     */
    public function getUrlAttribute(): string
    {
        if ($this->media_type === 'embed' || str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }

        return asset('storage/' . $this->file_path);
    }

    /**
     * Tag markdown / shortcode siap disisipkan ke editor artikel.
     */
    public function getMarkdownTagAttribute(): string
    {
        $caption = $this->caption ?: $this->file_name;

        if ($this->media_type === 'image') {
            return "![" . $caption . "](" . $this->url . ")";
        }

        return "[video: " . $this->url . ($this->caption ? " | " . $this->caption : "") . "]";
    }

    /**
     * Format ukuran berkas ramah baca (KB/MB).
     */
    public function getFormattedSizeAttribute(): string
    {
        if (!$this->file_size) {
            return '-';
        }

        if ($this->file_size >= 1048576) {
            return number_format($this->file_size / 1048576, 2) . ' MB';
        }

        return number_format($this->file_size / 1024, 1) . ' KB';
    }

    /**
     * Hapus berkas fisik di disk saat record dihapus.
     */
    protected static function booted()
    {
        static::deleting(function ($media) {
            if ($media->media_type !== 'embed' && !empty($media->file_path)) {
                if (!str_starts_with($media->file_path, 'http://') && !str_starts_with($media->file_path, 'https://')) {
                    Storage::disk('public')->delete($media->file_path);
                }
            }
        });
    }
}
