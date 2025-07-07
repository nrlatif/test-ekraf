<?php

namespace App\Filament\Widgets;

use App\Models\Katalog;
use App\Models\Product;
use App\Models\Artikel;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class RecentActivitiesWidget extends BaseWidget
{
    protected static ?string $heading = 'Aktivitas Terbaru';
    
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Combine recent katalogs, products, and articles
                Katalog::query()
                    ->select(['id', 'title as name', 'created_at', DB::raw("'Katalog' as type")])
                    ->unionAll(
                        Product::query()
                            ->select(['id', 'name', 'uploaded_at as created_at', DB::raw("'Produk' as type")])
                    )
                    ->unionAll(
                        Artikel::query()
                            ->select(['id', 'title as name', 'created_at', DB::raw("'Artikel' as type")])
                    )
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Katalog' => 'success',
                        'Produk' => 'info',
                        'Artikel' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}
