<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostMediaController extends Controller
{
    /**
     * Upload berkas foto/video atau simpan tautan video embed.
     */
    public function store(Request $request): JsonResponse
    {
        $mediaTypeInput = $request->input('media_type');

        if ($mediaTypeInput === 'embed') {
            $validated = $request->validate([
                'post_id' => ['nullable', 'exists:posts,id'],
                'temp_token' => ['nullable', 'string', 'max:64'],
                'embed_url' => ['required', 'url', 'max:500'],
                'caption' => ['nullable', 'string', 'max:255'],
            ]);

            $postId = $validated['post_id'] ?? null;
            $tempToken = $validated['temp_token'] ?? null;

            $maxOrder = PostMedia::where(function ($q) use ($postId, $tempToken) {
                if ($postId) {
                    $q->where('post_id', $postId);
                } elseif ($tempToken) {
                    $q->where('temp_token', $tempToken);
                }
            })->max('order') ?? 0;

            $media = PostMedia::create([
                'post_id' => $postId,
                'temp_token' => $tempToken,
                'file_path' => $validated['embed_url'],
                'file_name' => 'Video Embed (' . parse_url($validated['embed_url'], PHP_URL_HOST) . ')',
                'media_type' => 'embed',
                'mime_type' => 'text/html',
                'file_size' => 0,
                'caption' => $validated['caption'] ?? null,
                'order' => $maxOrder + 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tautan video berhasil ditambahkan!',
                'media' => $media,
            ]);
        }

        // Upload berkas fisik (foto atau video)
        $validated = $request->validate([
            'post_id' => ['nullable', 'exists:posts,id'],
            'temp_token' => ['nullable', 'string', 'max:64'],
            'caption' => ['nullable', 'string', 'max:255'],
            'file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,gif,svg,mp4,webm,ogg,quicktime',
                'max:51200', // Maks 50 MB
            ],
        ]);

        $file = $request->file('file');
        $mime = $file->getMimeType();
        $size = $file->getSize();
        $originalName = $file->getClientOriginalName();

        $mediaType = str_starts_with($mime, 'video/') ? 'video' : 'image';

        // Simpan ke storage/app/public/posts/media
        $path = $file->store('posts/media', 'public');

        $postId = $validated['post_id'] ?? null;
        $tempToken = $validated['temp_token'] ?? null;

        $maxOrder = PostMedia::where(function ($q) use ($postId, $tempToken) {
            if ($postId) {
                $q->where('post_id', $postId);
            } elseif ($tempToken) {
                $q->where('temp_token', $tempToken);
            }
        })->max('order') ?? 0;

        $media = PostMedia::create([
            'post_id' => $postId,
            'temp_token' => $tempToken,
            'file_path' => $path,
            'file_name' => $originalName,
            'media_type' => $mediaType,
            'mime_type' => $mime,
            'file_size' => $size,
            'caption' => $validated['caption'] ?? null,
            'order' => $maxOrder + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => ($mediaType === 'video' ? 'Video' : 'Foto') . ' berhasil diunggah!',
            'media' => $media,
        ]);
    }

    /**
     * Perbarui caption atau urutan berkas media.
     */
    public function update(Request $request, PostMedia $media): JsonResponse
    {
        $validated = $request->validate([
            'caption' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $media->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Keterangan media berhasil disimpan!',
            'media' => $media->fresh(),
        ]);
    }

    /**
     * Hapus berkas media dari server dan basis data.
     */
    public function destroy(PostMedia $media): JsonResponse
    {
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berkas media berhasil dihapus!',
        ]);
    }

    /**
     * Susun ulang (reorder) urutan media.
     */
    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:post_media,id'],
            'items.*.order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['items'] as $item) {
            PostMedia::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan media berhasil diperbarui!',
        ]);
    }
}
