<?php

namespace App\Observers;

use App\Models\Artikel;
use App\Http\Controllers\Api\SyncController;
use Illuminate\Support\Facades\Log;

class ArtikelObserver
{
    private $syncController;

    public function __construct()
    {
        $this->syncController = new SyncController();
    }

    /**
     * Handle the Artikel "created" event.
     */
    public function created(Artikel $artikel): void
    {
        $this->syncToNextjs($artikel, 'created');
    }

    /**
     * Handle the Artikel "updated" event.
     */
    public function updated(Artikel $artikel): void
    {
        $this->syncToNextjs($artikel, 'updated');
    }

    /**
     * Handle the Artikel "deleted" event.
     */
    public function deleted(Artikel $artikel): void
    {
        $this->syncToNextjs($artikel, 'deleted');
    }

    /**
     * Sync artikel data to Next.js API
     */
    private function syncToNextjs(Artikel $artikel, string $action): void
    {
        try {
            Log::info("ArtikelObserver: Syncing artikel {$artikel->id} to Next.js", [
                'action' => $action,
                'artikel_id' => $artikel->id,
                'artikel_title' => $artikel->title
            ]);

            // Prepare artikel data
            $artikelData = [
                'id' => $artikel->id,
                'author_id' => $artikel->author_id,
                'artikel_kategori_id' => $artikel->artikel_kategori_id,
                'title' => $artikel->title,
                'slug' => $artikel->slug,
                'content' => $artikel->content,
                'excerpt' => $artikel->excerpt,
                'thumbnail' => $artikel->thumbnail,
                'thumbnail_url' => $artikel->thumbnail_url, // This will use the smart accessor
                'thumbnail_cloudinary_id' => $artikel->thumbnail_cloudinary_id,
                'meta_description' => $artikel->meta_description,
                'tags' => $artikel->tags,
                'published_at' => $artikel->published_at?->toISOString(),
                'status' => $artikel->status,
                'views' => $artikel->views,
                'featured' => $artikel->featured,
                'created_at' => $artikel->created_at?->toISOString(),
                'updated_at' => $artikel->updated_at?->toISOString(),
            ];

            if ($action === 'deleted') {
                // For deleted articles, only send ID
                $artikelData = ['id' => $artikel->id];
            }

            // Send to Next.js API
            $response = $this->syncController->pushSingleToNextjs('articles', $artikelData, $action);
            
            Log::info("ArtikelObserver: Sync response", [
                'artikel_id' => $artikel->id,
                'action' => $action,
                'response' => $response
            ]);

        } catch (\Exception $e) {
            Log::error("ArtikelObserver: Failed to sync artikel {$artikel->id} to Next.js", [
                'action' => $action,
                'error' => $e->getMessage(),
                'artikel_id' => $artikel->id
            ]);
        }
    }
}
