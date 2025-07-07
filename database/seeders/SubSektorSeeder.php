<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubSektor;
use Illuminate\Support\Str;

class SubSektorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subSektors = [
            [
                'title' => 'Aplikasi dan Game Developer',
                'description' => 'Pengembangan perangkat lunak aplikasi dan permainan digital untuk berbagai platform seperti mobile, web, dan desktop.',
            ],
            [
                'title' => 'Arsitektur',
                'description' => 'Kegiatan kreatif yang berkaitan dengan desain bangunan secara menyeluruh, baik dari level makro (perencanaan kota) hingga mikro (detail konstruksi).',
            ],
            [
                'title' => 'Desain Interior',
                'description' => 'Kegiatan kreatif yang berkaitan dengan desain interior untuk berbagai fungsi ruang seperti rumah tinggal, perkantoran, retail, hingga ruang publik.',
            ],
            [
                'title' => 'Desain Komunikasi Visual',
                'description' => 'Kegiatan kreatif yang berkaitan dengan komunikasi menggunakan elemen visual seperti ilustrasi, fotografi, tipografi, dan tata letak.',
            ],
            [
                'title' => 'Desain Produk',
                'description' => 'Kegiatan kreatif yang berkaitan dengan penciptaan desain yang berguna, indah, dan berkesinambungan serta dapat diproduksi dengan skala industri.',
            ],
            [
                'title' => 'Fashion',
                'description' => 'Kegiatan kreatif yang berkaitan dengan kreasi desain pakaian, desain alas kaki, dan desain aksesoris mode lainnya.',
            ],
            [
                'title' => 'Film, Animasi dan Video',
                'description' => 'Kegiatan kreatif yang berkaitan dengan kreasi produksi video, film, dan jasa fotografi, serta distribusinya.',
            ],
            [
                'title' => 'Fotografi',
                'description' => 'Kegiatan kreatif yang berkaitan dengan kreasi karya fotografi dan jasa fotografi untuk berbagai keperluan komersial dan seni.',
            ],
            [
                'title' => 'Kriya',
                'description' => 'Kegiatan kreatif yang berkaitan dengan kreasi dan produksi barang kerajinan yang dibuat secara manual oleh tenaga pengrajin.',
            ],
            [
                'title' => 'Kuliner',
                'description' => 'Kegiatan kreatif yang berkaitan dengan kreasi, produksi, dan pemasaran makanan dan minuman yang memiliki keunikan dan nilai tambah.',
            ],
            [
                'title' => 'Musik',
                'description' => 'Kegiatan kreatif yang berkaitan dengan kreasi/komposisi, pertunjukan, reproduksi, dan distribusi dari rekaman suara.',
            ],
            [
                'title' => 'Penerbitan',
                'description' => 'Kegiatan kreatif yang berkaitan dengan penulisan konten dan penerbitan buku, jurnal, koran, majalah, tabloid, dan konten digital.',
            ],
            [
                'title' => 'Periklanan',
                'description' => 'Kegiatan kreatif yang berkaitan dengan kreasi dan produksi iklan, kampanye relasi publik, dan kampanye pemasaran lainnya.',
            ],
            [
                'title' => 'Performing Arts',
                'description' => 'Kegiatan kreatif yang berkaitan dengan karya seni pertunjukan seperti teater, tari, musik tradisional, dan seni pertunjukan lainnya.',
            ],
            [
                'title' => 'Seni Rupa',
                'description' => 'Kegiatan kreatif yang berkaitan dengan kreasi karya seni yang murni estetis, ekspresif, dan individual yang dapat dinikmati secara visual.',
            ],
            [
                'title' => 'Televisi dan Radio',
                'description' => 'Kegiatan kreatif yang berkaitan dengan usaha kreasi, produksi dan pengemasan acara televisi dan radio.',
            ],
            [
                'title' => 'Digital Marketing',
                'description' => 'Kegiatan kreatif yang berkaitan dengan strategi pemasaran digital, content creation, social media management, dan optimasi platform digital.',
            ],
        ];

        foreach ($subSektors as $subSektor) {
            SubSektor::create([
                'title' => $subSektor['title'],
                'slug' => Str::slug($subSektor['title']),
                'description' => $subSektor['description'],
                'image' => null, // Image akan diupload manual melalui admin panel
            ]);
        }
    }
}
