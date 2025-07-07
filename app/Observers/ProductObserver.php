<?php

namespace App\Observers;

use App\Models\Product;
use App\Http\Controllers\Api\SyncController;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    private $syncController;

    public function __construct()
    {
        $this->syncController = new SyncController();
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->syncToNextjs($product, 'created');
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this->syncToNextjs($product, 'updated');
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->syncToNextjs($product, 'deleted');
    }

    /**
     * Sync product data to Next.js API
     */
    private function syncToNextjs(Product $product, string $action): void
    {
        try {
            Log::info("ProductObserver: Syncing product {$product->id} to Next.js", [
                'action' => $action,
                'product_id' => $product->id,
                'product_name' => $product->name
            ]);

            // Prepare product data
            $productData = [
                'id' => $product->id,
                'user_id' => $product->user_id,
                'business_category_id' => $product->business_category_id,
                'owner_name' => $product->owner_name,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image,
                'image_url' => $product->image_url, // This will use the smart accessor
                'cloudinary_id' => $product->cloudinary_id,
                'phone_number' => $product->phone_number,
                'uploaded_at' => $product->uploaded_at?->toISOString(),
                'status' => $product->status,
                'created_at' => $product->created_at?->toISOString(),
                'updated_at' => $product->updated_at?->toISOString(),
            ];

            if ($action === 'deleted') {
                // For deleted products, only send ID
                $productData = ['id' => $product->id];
            }

            // Send to Next.js API
            $response = $this->syncController->pushSingleToNextjs('products', $productData, $action);
            
            Log::info("ProductObserver: Sync response", [
                'product_id' => $product->id,
                'action' => $action,
                'response' => $response
            ]);

        } catch (\Exception $e) {
            Log::error("ProductObserver: Failed to sync product {$product->id} to Next.js", [
                'action' => $action,
                'error' => $e->getMessage(),
                'product_id' => $product->id
            ]);
        }
    }
}
