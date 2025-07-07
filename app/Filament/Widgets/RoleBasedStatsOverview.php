<?php

namespace App\Filament\Widgets;

use App\Models\Katalog;
use App\Models\Product;
use App\Models\Artikel;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class RoleBasedStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        
        if (!$user) {
            return [];
        }
        
        if ($user->level_id === 1) { // SuperAdmin
            // Superadmin dapat melihat semua statistik
            return [
                Stat::make('Total Katalog', Katalog::count())
                    ->description('Katalog UMKM terdaftar')
                    ->descriptionIcon('heroicon-m-book-open')
                    ->color('success')
                    ->chart([7, 2, 10, 3, 15, 4, 17]),

                Stat::make('Total Produk', Product::count())
                    ->description('Produk dalam katalog')
                    ->descriptionIcon('heroicon-m-shopping-bag')
                    ->color('info')
                    ->chart([2, 5, 3, 8, 6, 12, 9]),

                Stat::make('Produk Disetujui', Product::where('status', 'disetujui')->count())
                    ->description('Produk yang telah disetujui')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),

                Stat::make('Total Artikel', Artikel::count())
                    ->description('Artikel publikasi')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('warning')
                    ->chart([3, 7, 5, 11, 8, 14, 10]),

                Stat::make('Total Pengguna', User::count())
                    ->description('Pengguna terdaftar')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('primary'),

                Stat::make('Admin & SuperAdmin', User::whereIn('level_id', [1, 2])->count())
                    ->description('Pengguna dengan akses admin')
                    ->descriptionIcon('heroicon-m-shield-check')
                    ->color('danger'),
            ];
        } elseif ($user->level_id === 2) { // Admin
            // Admin hanya dapat melihat statistik konten, tidak user management
            return [
                Stat::make('Total Katalog', Katalog::count())
                    ->description('Katalog UMKM terdaftar')
                    ->descriptionIcon('heroicon-m-book-open')
                    ->color('success')
                    ->chart([7, 2, 10, 3, 15, 4, 17]),

                Stat::make('Total Produk', Product::count())
                    ->description('Produk dalam katalog')
                    ->descriptionIcon('heroicon-m-shopping-bag')
                    ->color('info')
                    ->chart([2, 5, 3, 8, 6, 12, 9]),

                Stat::make('Produk Pending', Product::where('status', 'pending')->count())
                    ->description('Menunggu persetujuan')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),

                Stat::make('Produk Disetujui', Product::where('status', 'disetujui')->count())
                    ->description('Produk yang telah disetujui')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),

                Stat::make('Total Artikel', Artikel::count())
                    ->description('Artikel publikasi')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('info')
                    ->chart([3, 7, 5, 11, 8, 14, 10]),

                Stat::make('Katalog Bulan Ini', Katalog::whereMonth('created_at', now()->month)->count())
                    ->description('Katalog ditambahkan bulan ini')
                    ->descriptionIcon('heroicon-m-calendar')
                    ->color('success'),
            ];
        }

        // Fallback untuk role lain
        return [];
    }
}
