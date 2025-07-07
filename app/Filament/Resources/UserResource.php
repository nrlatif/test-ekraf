<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        // Hanya superadmin yang bisa mengakses User Resource
        $user = Auth::user();
        return $user && $user->level_id === 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Profile Picture')
                            ->image()
                            ->directory('users')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(5120) // 5MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('200')
                            ->imageResizeTargetHeight('200')
                            ->avatar()
                            ->nullable()
                            ->columnSpanFull()
                            ->helperText('Upload avatar user. Gambar akan diupload ke Cloudinary. Ukuran ideal: 200x200px'),
                            
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('username')
                            ->unique(User::class, 'username', ignoreRecord: true)
                            ->maxLength(45)
                            ->nullable(),
                            
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->maxLength(255),
                            
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female'
                            ])
                            ->nullable(),
                            
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->maxLength(20)
                            ->nullable(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Business Information')
                    ->schema([
                        Forms\Components\TextInput::make('business_name')
                            ->maxLength(100)
                            ->nullable(),
                            
                        Forms\Components\Select::make('business_status')
                            ->options([
                                'individual' => 'Individual',
                                'company' => 'Company',
                                'partnership' => 'Partnership'
                            ])
                            ->nullable(),
                            
                        Forms\Components\Select::make('level_id')
                            ->relationship('level', 'name')
                            ->required()
                            ->preload(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Profile Picture')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level.name')
                    ->label('Level')
                    ->sortable(),
                Tables\Columns\TextColumn::make('business_name')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
