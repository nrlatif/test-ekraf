<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Filament\Resources\ArtikelResource\RelationManagers;
use App\Models\Artikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('author_id')
                ->relationship('author', 'name')
                ->required(),
                Forms\Components\Select::make('artikel_kategori_id')
                ->relationship('artikelkategori', 'title')
                ->required(),
                Forms\Components\TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state, ?string $old, $record) {
                        if ($state !== $old) {
                            $baseSlug = Str::slug($state);
                            $slug = $baseSlug;
                            $counter = 1;
                            
                            // Ensure unique slug
                            while (Artikel::where('slug', $slug)
                                ->when($record, fn($query) => $query->where('id', '!=', $record->id))
                                ->exists()) {
                                $slug = $baseSlug . '-' . $counter;
                                $counter++;
                            }
                            
                            $set('slug', $slug);
                        }
                    })
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->readOnly()
                    ->unique(Artikel::class, 'slug', ignoreRecord: true)
                    ->helperText('Slug akan dibuat otomatis dari title'),
                
                Forms\Components\Section::make('Current Thumbnail')
                    ->description('Gambar thumbnail yang saat ini digunakan')
                    ->schema([
                        Forms\Components\Placeholder::make('current_thumbnail')
                            ->label('')
                            ->content(function ($record) {
                                if ($record && $record->cloudinary_id) {
                                    return new \Illuminate\Support\HtmlString(
                                        '<div class="flex items-center gap-4">
                                            <img src="' . $record->thumbnail_url . '" alt="Current thumbnail" class="w-32 h-20 object-cover rounded">
                                            <div>
                                                <p class="text-sm font-medium">Gambar disimpan di Cloudinary</p>
                                                <p class="text-xs text-gray-500">Upload gambar baru untuk mengganti</p>
                                            </div>
                                        </div>'
                                    );
                                }
                                return 'Belum ada gambar yang diupload';
                            })
                    ])
                    ->collapsible()
                    ->hidden(fn ($record) => !$record || !$record->cloudinary_id),
                
                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Article Thumbnail')
                    ->image()
                    ->directory('articles')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(10240) // 10MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('800')
                    ->imageResizeTargetHeight('450')
                    ->columnSpanFull()
                    ->live()
                    ->helperText('Upload thumbnail untuk artikel. Gambar akan diupload ke external service (Android-compatible) dengan Cloudinary sebagai fallback. Ukuran ideal: 800x450px. Max: 10MB'),
                Forms\Components\RichEditor::make('content')
                ->required()
                ->columnSpanFull(),
                Forms\Components\Toggle::make('is_featured')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->square()
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('artikelkategori.title')
                    ->label('Category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('banners_count')
                    ->label('Banners')
                    ->counts('banners')
                    ->suffix(' banner(s)')
                    ->color('success')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->limit(25)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Featured')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author_id')
                ->relationship('author','name'),
                Tables\Filters\SelectFilter::make('artikel_kategori_id')
                ->relationship('artikelkategori','title')
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
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}
