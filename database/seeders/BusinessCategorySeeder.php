<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID subsektor kuliner
        $kulinerSubSector = DB::table('sub_sectors')->where('slug', 'kuliner')->first();
        
        if ($kulinerSubSector) {
            $businessCategories = [
                [
                    'name' => 'Makanan',
                    'image' => null,
                    'sub_sector_id' => $kulinerSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang makanan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Minuman',
                    'image' => null,
                    'sub_sector_id' => $kulinerSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang minuman',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Makanan Ringan',
                    'image' => null,
                    'sub_sector_id' => $kulinerSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang makanan ringan dan camilan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kue dan Pastry',
                    'image' => null,
                    'sub_sector_id' => $kulinerSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang kue dan pastry',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Katering',
                    'image' => null,
                    'sub_sector_id' => $kulinerSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang katering dan layanan makanan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('business_categories')->insert($businessCategories);
        }

        // Ambil ID subsektor fashion
        $fashionSubSector = DB::table('sub_sectors')->where('slug', 'fashion')->first();
        
        if ($fashionSubSector) {
            $fashionCategories = [
                [
                    'name' => 'Pakaian Pria',
                    'image' => null,
                    'sub_sector_id' => $fashionSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang fashion pakaian pria',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pakaian Wanita',
                    'image' => null,
                    'sub_sector_id' => $fashionSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang fashion pakaian wanita',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pakaian Anak',
                    'image' => null,
                    'sub_sector_id' => $fashionSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang fashion pakaian anak',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Aksesoris Fashion',
                    'image' => null,
                    'sub_sector_id' => $fashionSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang aksesoris fashion',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sepatu dan Sandal',
                    'image' => null,
                    'sub_sector_id' => $fashionSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang sepatu dan sandal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('business_categories')->insert($fashionCategories);
        }

        // Ambil ID subsektor kriya
        $kriyaSubSector = DB::table('sub_sectors')->where('slug', 'kriya')->first();
        
        if ($kriyaSubSector) {
            $kriyaCategories = [
                [
                    'name' => 'Kerajinan Kayu',
                    'image' => null,
                    'sub_sector_id' => $kriyaSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang kerajinan kayu',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kerajinan Logam',
                    'image' => null,
                    'sub_sector_id' => $kriyaSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang kerajinan logam',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kerajinan Tekstil',
                    'image' => null,
                    'sub_sector_id' => $kriyaSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang kerajinan tekstil',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kerajinan Keramik',
                    'image' => null,
                    'sub_sector_id' => $kriyaSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang kerajinan keramik',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kerajinan Anyaman',
                    'image' => null,
                    'sub_sector_id' => $kriyaSubSector->id,
                    'description' => 'Kategori usaha yang bergerak dalam bidang kerajinan anyaman',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('business_categories')->insert($kriyaCategories);
        }
    }
}
