<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KatalogResource\Pages;
use App\Models\Katalog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KatalogResource extends Resource
{
    protected static ?string $model = Katalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sub_sector_id')
                    ->relationship('subSektor', 'title')
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required(),

                Forms\Components\TextInput::make('slug')
                    ->readOnly(),

                Forms\Components\FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->directory('katalogs')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(8192) // 8MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('4:3')
                    ->imageResizeTargetWidth('800')
                    ->imageResizeTargetHeight('600')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Upload gambar katalog. Gambar akan diupload ke Cloudinary. Ukuran ideal: 800x600px (4:3). Max: 8MB'),

                Forms\Components\RichEditor::make('content')
                    ->label('Deskripsi Katalog')
                    ->required()
                    ->columnSpanFull(),

                // Informasi Kontak
                Forms\Components\Section::make('Informasi Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('contact')
                            ->label('Kontak')
                            ->maxLength(255)
                            ->placeholder('Nama kontak atau person in charge'),
                        
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor Telepon/WhatsApp')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('081234567890'),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('email@example.com'),
                    ])->columns(2),

                // Media Sosial & Toko Online
                Forms\Components\Section::make('Media Sosial & Toko Online')
                    ->schema([
                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/username')
                            ->prefixIcon('heroicon-o-at-symbol'),
                        
                        Forms\Components\TextInput::make('shopee')
                            ->label('Shopee')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://shopee.co.id/shop/username')
                            ->prefixIcon('heroicon-o-shopping-cart'),
                        
                        Forms\Components\TextInput::make('tokopedia')
                            ->label('Tokopedia')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://tokopedia.com/shop-name')
                            ->prefixIcon('heroicon-o-building-storefront'),
                        
                        Forms\Components\TextInput::make('lazada')
                            ->label('Lazada')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://lazada.co.id/shop/shop-name')
                            ->prefixIcon('heroicon-o-globe-alt'),
                    ])->columns(2),

                // Relasi dengan Products
                Forms\Components\Select::make('products')
                    ->label('Related Products')
                    ->multiple()
                    ->relationship('products', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('Pilih produk yang akan ditampilkan di katalog ini.')
                    ->columnSpanFull(),

                // Fields lama disembunyikan tapi tetap ada untuk backward compatibility
                Forms\Components\Hidden::make('product_name')
                    ->default(''),
                Forms\Components\Hidden::make('price')
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->square()
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('subSektor.title')
                    ->label('Sub Sektor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sub_sector_id')
                    ->relationship('subSektor', 'title'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKatalogs::route('/'),
            'create' => Pages\CreateKatalog::route('/create'),
            'edit' => Pages\EditKatalog::route('/{record}/edit'),
        ];
    }
}
