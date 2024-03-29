<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetDisk;
use App\Models\AssetMemory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@demo.com',
        ]);

        $this->call(BrandSeeder::class);

        // Asset::factory(10)->create()->each(function ($asset) {
        //     AssetMemory::factory(1)->create([
        //         'asset_id' => $asset->id,
        //     ]);
        //     AssetDisk::factory(5)->create([
        //         'asset_id' => $asset->id,
        //     ]);
        // });
    }
}
