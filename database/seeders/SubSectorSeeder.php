<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subSectors = [
            [
                'title' => 'Kuliner',
                'slug' => 'kuliner',
                'description' => 'Subsektor yang bergerak dalam bidang makanan dan minuman',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Subsektor yang bergerak dalam bidang mode dan pakaian',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kriya',
                'slug' => 'kriya',
                'description' => 'Subsektor yang bergerak dalam bidang kerajinan tangan',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Aplikasi dan Game Developer',
                'slug' => 'aplikasi-dan-game-developer',
                'description' => 'Subsektor yang bergerak dalam bidang pengembangan aplikasi dan game',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Musik',
                'slug' => 'musik',
                'description' => 'Subsektor yang bergerak dalam bidang musik dan audio',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Arsitektur',
                'slug' => 'arsitektur',
                'description' => 'Subsektor yang bergerak dalam bidang desain arsitektur',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Desain Interior',
                'slug' => 'desain-interior',
                'description' => 'Subsektor yang bergerak dalam bidang desain interior',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Desain Komunikasi Visual',
                'slug' => 'desain-komunikasi-visual',
                'description' => 'Subsektor yang bergerak dalam bidang desain grafis dan komunikasi visual',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Desain Produk',
                'slug' => 'desain-produk',
                'description' => 'Subsektor yang bergerak dalam bidang desain produk',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Film, Animasi dan Video',
                'slug' => 'film-animasi-dan-video',
                'description' => 'Subsektor yang bergerak dalam bidang film, animasi, dan video',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Fotografi',
                'slug' => 'fotografi',
                'description' => 'Subsektor yang bergerak dalam bidang fotografi',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Penerbitan',
                'slug' => 'penerbitan',
                'description' => 'Subsektor yang bergerak dalam bidang penerbitan buku dan media',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Periklanan',
                'slug' => 'periklanan',
                'description' => 'Subsektor yang bergerak dalam bidang periklanan dan promosi',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seni Pertunjukan',
                'slug' => 'seni-pertunjukan',
                'description' => 'Subsektor yang bergerak dalam bidang seni pertunjukan',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seni Rupa',
                'slug' => 'seni-rupa',
                'description' => 'Subsektor yang bergerak dalam bidang seni rupa',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Televisi dan Radio',
                'slug' => 'televisi-dan-radio',
                'description' => 'Subsektor yang bergerak dalam bidang televisi dan radio',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Riset dan Pengembangan',
                'slug' => 'riset-dan-pengembangan',
                'description' => 'Subsektor yang bergerak dalam bidang riset dan pengembangan',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('sub_sectors')->insert($subSectors);
    }
}
