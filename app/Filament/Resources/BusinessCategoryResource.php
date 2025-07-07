<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessCategoryResource\Pages;
use App\Models\BusinessCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BusinessCategoryResource extends Resource
{
    protected static ?string $model = BusinessCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Business Categories';

    protected static ?string $pluralLabel = 'Business Categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Category Name')
                    ->required()
                    ->maxLength(50)
                    ->unique(BusinessCategory::class, 'name', ignoreRecord: true),

                Forms\Components\FileUpload::make('image')
                    ->label('Category Icon/Image')
                    ->image()
                    ->directory('business-categories')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(1024) // 1MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('200')
                    ->imageResizeTargetHeight('200')
                    ->helperText('Upload an icon or image for this category. SVG, PNG, JPEG, WebP allowed.')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->square(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListBusinessCategories::route('/'),
            'create' => Pages\CreateBusinessCategory::route('/create'),
            'edit' => Pages\EditBusinessCategory::route('/{record}/edit'),
        ];
    }
}
