<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'HP',
            'Dell',
            'Lenovo',
            'Asus',
            'Acer',
            'MSI',
            'Samsung',
            'LG',
            'Toshiba',
            'Apple',
            'Xiaomi',
            'Huawei',
            'Nokia',
            'Sony',
            'Philips',
            'Panasonic',
            'Vizio',
            'JVC',
            'Sharp',
        ];

        collect($brands)->each(function ($brand) {
            \App\Models\Brand::updateOrCreate([
                'name' => $brand,
            ]);
        });
    }
}
