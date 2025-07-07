<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PendingProductsWidget extends BaseWidget
{
    protected static ?string $heading = 'Produk Menunggu Persetujuan';
    
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        // Hanya superadmin dan admin yang bisa melihat widget ini
        $user = Auth::user();
        return $user && ($user->level_id === 1 || $user->level_id === 2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('status', 'pending')
                    ->with(['businessCategory', 'user'])
                    ->orderBy('uploaded_at', 'desc')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->square()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_name')
                    ->label('Pemilik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('businessCategory.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('uploaded_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (Product $record) {
                        $record->update(['status' => 'disetujui']);
                        $this->resetTable();
                    })
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(function (Product $record) {
                        $record->update(['status' => 'ditolak']);
                        $this->resetTable();
                    })
                    ->requiresConfirmation(),
            ])
            ->defaultSort('uploaded_at', 'desc')
            ->paginated([5, 10]);
    }
}
