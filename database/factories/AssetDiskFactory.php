<?php

namespace Database\Factories;

use App\Enums\DiskType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssetDisk>
 */
class AssetDiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'size' => $this->faker->numberBetween(500, 5000),
            'type' => $this->faker->randomElement(collect(DiskType::cases())->pluck('value')->toArray()),
        ];
    }
}
