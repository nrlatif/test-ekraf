<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\User;
use App\Models\BusinessCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $pluralLabel = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('business_category_id')
                    ->label('Business Category')
                    ->relationship('businessCategory', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('owner_name')
                    ->label('Owner Name')
                    ->required()
                    ->maxLength(35),

                Forms\Components\TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(50),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->maxLength(500)
                    ->rows(4),

                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Forms\Components\TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->required()
                    ->default(0),

                Forms\Components\FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->directory('products')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(8192) // 8MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('500')
                    ->imageResizeTargetHeight('500')
                    ->required()
                    ->helperText('Upload gambar produk. Gambar akan diupload ke Cloudinary. Ukuran ideal: 500x500px (1:1). Max: 8MB'),

                Forms\Components\TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->tel()
                    ->maxLength(12)
                    ->required(),

                Forms\Components\DateTimePicker::make('uploaded_at')
                    ->label('Uploaded At')
                    ->default(now()),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'disetujui' => 'Approved',
                        'ditolak' => 'Rejected',
                        'tidak aktif' => 'Inactive',
                    ])
                    ->default('pending')
                    ->required(),

                // Relasi dengan Katalogs
                Forms\Components\Select::make('katalogs')
                    ->label('Featured in Catalogs')
                    ->multiple()
                    ->relationship('katalogs', 'title')
                    ->searchable()
                    ->preload()
                    ->helperText('Pilih katalog dimana produk ini akan ditampilkan.')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('owner_name')
                    ->label('Owner')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('businessCategory.name')
                    ->label('Category')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->square(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                        'secondary' => 'tidak aktif',
                    ]),

                Tables\Columns\TextColumn::make('uploaded_at')
                    ->label('Uploaded')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'disetujui' => 'Approved',
                        'ditolak' => 'Rejected',
                        'tidak aktif' => 'Inactive',
                    ]),

                Tables\Filters\SelectFilter::make('business_category_id')
                    ->label('Category')
                    ->relationship('businessCategory', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
