<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use App\Models\Artikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Banner Title')
                    ->required()
                    ->maxLength(100)
                    ->helperText('Title yang akan ditampilkan pada banner'),
                    
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(255)
                    ->helperText('Deskripsi singkat banner (opsional)')
                    ->nullable(),

                Forms\Components\Select::make('artikel_id')
                    ->label('Artikel Terkait')
                    ->relationship('artikel', 'title')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('Pilih artikel untuk ditampilkan di banner')
                    ->helperText('Artikel yang akan ditampilkan ketika banner diklik'),
                    
                Forms\Components\FileUpload::make('image')
                    ->label('Banner Image')
                    ->image()
                    ->directory('banners')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(15360) // 15MB
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1200')
                    ->imageResizeTargetHeight('675')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Upload gambar banner untuk slider. Gambar akan diupload ke Cloudinary. Ukuran ideal: 1200x675px (16:9). Max: 15MB')
                    ->uploadingMessage('Uploading banner image...')
                    ->downloadable()
                    ->openable()
                    ->previewable(),
                    
                Forms\Components\TextInput::make('link_url')
                    ->label('Link URL')
                    ->url()
                    ->nullable()
                    ->placeholder('https://example.com')
                    ->helperText('URL tujuan ketika banner diklik (opsional)'),
                    
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Aktifkan banner untuk ditampilkan'),
                    
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Urutan tampilan banner (angka kecil tampil duluan)')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Banner Image')
                    ->square()
                    ->size(80),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('artikel.title')
                    ->label('Artikel Terkait')
                    ->searchable()
                    ->sortable()
                    ->limit(25)
                    ->placeholder('Tidak ada artikel'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(40)
                    ->placeholder('No description')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('link_url')
                    ->label('Link URL')
                    ->limit(30)
                    ->url(fn($record) => $record->link_url)
                    ->openUrlInNewTab()
                    ->placeholder('No link'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All banners')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
