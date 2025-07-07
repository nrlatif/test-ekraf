<?php

namespace App\Observers;

use App\Models\Author;
use App\Http\Controllers\Api\SyncController;
use Illuminate\Support\Facades\Log;

class AuthorObserver
{
    private $syncController;

    public function __construct()
    {
        $this->syncController = new SyncController();
    }

    /**
     * Handle the Author "created" event.
     */
    public function created(Author $author): void
    {
        $this->syncToNextjs($author, 'created');
    }

    /**
     * Handle the Author "updated" event.
     */
    public function updated(Author $author): void
    {
        $this->syncToNextjs($author, 'updated');
    }

    /**
     * Handle the Author "deleted" event.
     */
    public function deleted(Author $author): void
    {
        $this->syncToNextjs($author, 'deleted');
    }

    /**
     * Sync author data to Next.js API
     */
    private function syncToNextjs(Author $author, string $action): void
    {
        try {
            Log::info("AuthorObserver: Syncing author {$author->id} to Next.js", [
                'action' => $action,
                'author_id' => $author->id,
                'author_name' => $author->name
            ]);

            // Prepare author data
            $authorData = [
                'id' => $author->id,
                'name' => $author->name,
                'email' => $author->email,
                'bio' => $author->bio,
                'avatar' => $author->avatar,
                'avatar_url' => $author->avatar_url, // This will use the smart accessor
                'cloudinary_id' => $author->cloudinary_id,
                'social_links' => $author->social_links,
                'status' => $author->status,
                'created_at' => $author->created_at?->toISOString(),
                'updated_at' => $author->updated_at?->toISOString(),
            ];

            if ($action === 'deleted') {
                // For deleted authors, only send ID
                $authorData = ['id' => $author->id];
            }

            // Send to Next.js API
            $response = $this->syncController->pushSingleToNextjs('authors', $authorData, $action);
            
            Log::info("AuthorObserver: Sync response", [
                'author_id' => $author->id,
                'action' => $action,
                'response' => $response
            ]);

        } catch (\Exception $e) {
            Log::error("AuthorObserver: Failed to sync author {$author->id} to Next.js", [
                'action' => $action,
                'error' => $e->getMessage(),
                'author_id' => $author->id
            ]);
        }
    }
}
