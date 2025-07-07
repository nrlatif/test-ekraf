<?php

namespace App\Observers;

use App\Models\Katalog;
use App\Http\Controllers\Api\SyncController;
use Illuminate\Support\Facades\Log;

class KatalogObserver
{
    private $syncController;

    public function __construct()
    {
        $this->syncController = new SyncController();
    }

    /**
     * Handle the Katalog "created" event.
     */
    public function created(Katalog $katalog): void
    {
        $this->syncToNextjs($katalog, 'created');
    }

    /**
     * Handle the Katalog "updated" event.
     */
    public function updated(Katalog $katalog): void
    {
        $this->syncToNextjs($katalog, 'updated');
    }

    /**
     * Handle the Katalog "deleted" event.
     */
    public function deleted(Katalog $katalog): void
    {
        $this->syncToNextjs($katalog, 'deleted');
    }

    /**
     * Sync katalog data to Next.js API
     */
    private function syncToNextjs(Katalog $katalog, string $action): void
    {
        try {
            Log::info("KatalogObserver: Syncing katalog {$katalog->id} to Next.js", [
                'action' => $action,
                'katalog_id' => $katalog->id,
                'katalog_title' => $katalog->title
            ]);

            // Prepare katalog data
            $katalogData = [
                'id' => $katalog->id,
                'sub_sector_id' => $katalog->sub_sector_id,
                'title' => $katalog->title,
                'slug' => $katalog->slug,
                'content' => $katalog->content,
                'image' => $katalog->image,
                'image_url' => $katalog->image_url, // This will use the smart accessor
                'cloudinary_id' => $katalog->cloudinary_id,
                'contact' => $katalog->contact,
                'phone_number' => $katalog->phone_number,
                'email' => $katalog->email,
                'instagram' => $katalog->instagram,
                'shopee' => $katalog->shopee,
                'tokopedia' => $katalog->tokopedia,
                'lazada' => $katalog->lazada,
                'created_at' => $katalog->created_at?->toISOString(),
                'updated_at' => $katalog->updated_at?->toISOString(),
            ];

            if ($action === 'deleted') {
                // For deleted katalogs, only send ID
                $katalogData = ['id' => $katalog->id];
            }

            // Send to Next.js API
            $response = $this->syncController->pushSingleToNextjs('katalogs', $katalogData, $action);
            
            Log::info("KatalogObserver: Sync response", [
                'katalog_id' => $katalog->id,
                'action' => $action,
                'response' => $response
            ]);

        } catch (\Exception $e) {
            Log::error("KatalogObserver: Failed to sync katalog {$katalog->id} to Next.js", [
                'action' => $action,
                'error' => $e->getMessage(),
                'katalog_id' => $katalog->id
            ]);
        }
    }
}
