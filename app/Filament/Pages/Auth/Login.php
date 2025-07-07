<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Actions\Action;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->autocomplete()
                    ->autofocus()
                    ->extraInputAttributes(['tabindex' => 1])
                    ->prefixIcon('heroicon-m-envelope')
                    ->placeholder('Masukkan alamat email Anda')
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->required()
                    ->extraInputAttributes(['tabindex' => 2])
                    ->prefixIcon('heroicon-m-lock-closed')
                    ->placeholder('Masukkan kata sandi Anda')
                    ->maxLength(255),
                Checkbox::make('remember')
                    ->label('Ingat saya di perangkat ini')
                    ->extraInputAttributes(['tabindex' => 3]),
            ])
            ->statePath('data');
    }

    protected function getHeaderWidget(): ?string
    {
        return null; // Menghilangkan widget header default
    }

    protected function getLayoutData(): array
    {
        return [
            'title' => 'EKRAF KUNINGAN - Admin Login',
        ];
    }

    public function getTitle(): string
    {
        return 'Login Admin EKRAF';
    }

    public function getHeading(): string
    {
        return 'Masuk ke Dashboard';
    }
}
