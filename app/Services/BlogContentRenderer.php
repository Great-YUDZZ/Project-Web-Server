<?php

namespace App\Services;

use Illuminate\Support\Str;

class BlogContentRenderer
{
    /**
     * Render konten artikel blog: mendukung markdown, foto dengan lightbox zoom, dan video player.
     */
    public static function render(?string $rawContent): string
    {
        if (empty($rawContent)) {
            return '';
        }

        // 1. Parse tag video kustom [video: URL | Caption] atau [video: URL]
        $content = self::processVideoTags($rawContent);

        // 2. Render Markdown ke HTML
        $html = Str::markdown($content);

        // 3. Post-process tag <img> menjadi figure responsif dengan trigger lightbox
        $html = self::processImagesForLightbox($html);

        return $html;
    }

    /**
     * Memproses tag [video: URL | Caption] atau [video: URL]
     */
    protected static function processVideoTags(string $content): string
    {
        // Regex untuk mencocokkan [video: URL | Caption] atau [video: URL]
        $pattern = '/\[video:\s*([^\|\]]+)(?:\|\s*([^\]]+))?\]/i';

        return preg_replace_callback($pattern, function ($matches) {
            $url = trim($matches[1]);
            $caption = isset($matches[2]) ? trim($matches[2]) : '';

            return self::buildVideoHtml($url, $caption);
        }, $content);
    }

    /**
     * Bangun komponen HTML untuk video (YouTube, Vimeo, atau berkas lokal MP4/WebM)
     */
    public static function buildVideoHtml(string $url, string $caption = ''): string
    {
        $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $safeCaption = htmlspecialchars($caption, ENT_QUOTES, 'UTF-8');

        $captionBlock = '';
        if (!empty($safeCaption)) {
            $captionBlock = '<div class="px-4 py-2.5 bg-white/[0.02] border-t border-white/5 text-xs text-stone-400 font-mono text-center flex items-center justify-center gap-2">
                <svg class="w-3.5 h-3.5 text-stone-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                </svg>
                <span>' . $safeCaption . '</span>
            </div>';
        }

        // Cek YouTube
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([^"&?\/ ]{11})/i', $url, $ytMatches)) {
            $videoId = $ytMatches[1];
            return '<div class="my-8 rounded-2xl overflow-hidden border border-white/10 bg-[#0d0d0d] shadow-xl">
                <div class="relative w-full aspect-video bg-black">
                    <iframe src="https://www.youtube-nocookie.com/embed/' . $videoId . '" 
                            class="absolute inset-0 w-full h-full border-0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen 
                            loading="lazy"></iframe>
                </div>
                ' . $captionBlock . '
            </div>';
        }

        // Cek Vimeo
        if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)/i', $url, $vmMatches)) {
            $videoId = $vmMatches[3];
            return '<div class="my-8 rounded-2xl overflow-hidden border border-white/10 bg-[#0d0d0d] shadow-xl">
                <div class="relative w-full aspect-video bg-black">
                    <iframe src="https://player.vimeo.com/video/' . $videoId . '" 
                            class="absolute inset-0 w-full h-full border-0" 
                            allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen 
                            loading="lazy"></iframe>
                </div>
                ' . $captionBlock . '
            </div>';
        }

        // Berkas video langsung (MP4, WebM, dll)
        return '<div class="my-8 rounded-2xl overflow-hidden border border-white/10 bg-[#0d0d0d] shadow-xl">
            <div class="relative w-full bg-black flex items-center justify-center">
                <video controls playsinline preload="metadata" class="w-full max-h-[520px] rounded-t-2xl bg-black">
                    <source src="' . $safeUrl . '">
                    Browser Anda tidak mendukung elemen video HTML5.
                </video>
            </div>
            ' . $captionBlock . '
        </div>';
    }

    /**
     * Memproses tag <img> dari markdown menjadi figure interaktif dengan zoom lightbox
     */
    protected static function processImagesForLightbox(string $html): string
    {
        // Ubah <p><img ...></p> atau <img ...> menjadi komponen figure dengan zoom lightbox
        $pattern = '/(?:<p>\s*)?<img\s+([^>]*?)src=["\']([^"\']+)["\']([^>]*?)>(?:\s*<\/p>)?/i';

        return preg_replace_callback($pattern, function ($matches) {
            $beforeSrc = $matches[1];
            $src = $matches[2];
            $afterSrc = $matches[3];

            // Ekstrak alt text jika ada
            $alt = '';
            if (preg_match('/alt=["\']([^"\']*)["\']/i', $beforeSrc . ' ' . $afterSrc, $altMatches)) {
                $alt = trim($altMatches[1]);
            }

            $safeSrc = htmlspecialchars($src, ENT_QUOTES, 'UTF-8');
            $safeAlt = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');

            $captionHtml = '';
            if (!empty($safeAlt) && strtolower($safeAlt) !== 'image' && strtolower($safeAlt) !== 'gambar') {
                $captionHtml = '<figcaption class="px-4 py-2.5 bg-white/[0.02] border-t border-white/5 text-xs text-stone-400 font-mono text-center flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-stone-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>' . $safeAlt . '</span>
                </figcaption>';
            }

            return '<figure class="my-8 rounded-2xl overflow-hidden border border-white/10 bg-[#0d0d0d] shadow-xl group">
                <div class="relative overflow-hidden cursor-zoom-in blog-lightbox-trigger bg-black/40 flex items-center justify-center p-1 sm:p-2" 
                     data-lightbox-src="' . $safeSrc . '" 
                     data-lightbox-caption="' . $safeAlt . '">
                    <img src="' . $safeSrc . '" 
                         alt="' . $safeAlt . '" 
                         loading="lazy" 
                         class="w-full max-h-[550px] object-contain rounded-xl transition-transform duration-300 group-hover:scale-[1.01]">
                    <div class="absolute bottom-3 right-3 px-2.5 py-1 rounded-lg bg-black/75 backdrop-blur-xs border border-white/15 text-[10px] font-mono text-stone-300 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1.5 pointer-events-none">
                        <svg class="w-3 h-3 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                        </svg>
                        <span>Klik untuk perbesar</span>
                    </div>
                </div>
                ' . $captionHtml . '
            </figure>';
        }, $html);
    }
}
