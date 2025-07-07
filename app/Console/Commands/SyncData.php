<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Api\SyncController;
use Illuminate\Http\Request;

class SyncData extends Command
{
    protected $signature = 'sync:data 
                            {action : The action to perform (status|from-nextjs|to-nextjs)}
                            {--type=all : Type of data to sync (all|authors|articles|products)}
                            {--id= : ID for specific item (required for to-nextjs)}';

    protected $description = 'Sync data between Laravel and Next.js backend';

    public function handle()
    {
        $action = $this->argument('action');
        $type = $this->option('type');
        $id = $this->option('id');

        $controller = new SyncController();

        switch ($action) {
            case 'status':
                $this->handleStatus($controller);
                break;
                
            case 'from-nextjs':
                $this->handleFromNextjs($controller, $type);
                break;
                
            case 'to-nextjs':
                $this->handleToNextjs($controller, $type, $id);
                break;
                
            default:
                $this->error('Invalid action. Use: status, from-nextjs, or to-nextjs');
                return 1;
        }

        return 0;
    }

    private function handleStatus($controller)
    {
        $this->info('🔍 Checking sync status...');
        
        $response = $controller->syncStatus();
        $data = $response->getData(true);

        if ($data['success']) {
            $this->info('✅ Sync Status Retrieved Successfully');
            $this->line('');
            
            foreach ($data['data'] as $type => $stats) {
                $this->info("📊 {$type}:");
                $this->line("   Total: {$stats['total']}");
                $this->line("   With URL (Next.js): {$stats['with_url']}");
                $this->line("   With Cloudinary: {$stats['with_cloudinary']}");
                $this->line("   Local/Legacy: {$stats['with_local']}");
                $this->line('');
            }
        } else {
            $this->error('❌ Failed to get sync status: ' . $data['message']);
        }
    }

    private function handleFromNextjs($controller, $type)
    {
        $this->info("🔄 Syncing {$type} from Next.js backend...");
        
        $request = new Request(['type' => $type]);
        $response = $controller->syncFromNextjs($request);
        $data = $response->getData(true);

        if ($data['success']) {
            $this->info('✅ Sync completed successfully!');
            
            if (isset($data['data'])) {
                foreach ($data['data'] as $dataType => $items) {
                    $count = is_array($items) ? count($items) : 0;
                    $this->line("   {$dataType}: {$count} items synced");
                    
                    if ($count > 0 && $count <= 10) {
                        // Show item names if not too many
                        foreach ($items as $item) {
                            $this->line("     - {$item}");
                        }
                    }
                }
            }
        } else {
            $this->error('❌ Sync failed: ' . $data['message']);
        }
    }

    private function handleToNextjs($controller, $type, $id)
    {
        if (!$id) {
            $this->error('❌ ID is required for pushing to Next.js. Use --id=123');
            return;
        }

        if (!in_array($type, ['author', 'article', 'product'])) {
            $this->error('❌ Type must be one of: author, article, product (not "all")');
            return;
        }

        $this->info("📤 Pushing {$type} #{$id} to Next.js backend...");
        
        $request = new Request(['type' => $type, 'id' => $id]);
        $response = $controller->pushToNextjs($request);
        $data = $response->getData(true);

        if ($data['success']) {
            $this->info('✅ Data pushed successfully!');
            if (isset($data['data'])) {
                $this->line('Response: ' . json_encode($data['data'], JSON_PRETTY_PRINT));
            }
        } else {
            $this->error('❌ Push failed: ' . $data['message']);
        }
    }
}
