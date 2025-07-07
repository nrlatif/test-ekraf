<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubSektorResource\Pages;
use App\Filament\Resources\SubSektorResource\RelationManagers;
use App\Models\SubSektor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SubSektorResource extends Resource
{
    protected static ?string $model = SubSektor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required()
                    ->maxLength(100),
                    
                Forms\Components\TextInput::make('slug')
                    ->readOnly(),
                    
                Forms\Components\FileUpload::make('image')
                    ->label('Sub Sector Image')
                    ->image()
                    ->directory('sub-sectors')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(2048) // 2MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('800')
                    ->imageResizeTargetHeight('450')
                    ->nullable()
                    ->columnSpanFull(),
                    
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(500)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListSubSektors::route('/'),
            'create' => Pages\CreateSubSektor::route('/create'),
            'edit' => Pages\EditSubSektor::route('/{record}/edit'),
        ];
    }
}
