<?php

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Verify if we can see the brand list', function () {
    $response = $this->getJson('/api/brands');

    expect($response->status())->toBe(200);
    expect($response->json('data'))->toBeArray();
    expect($response->json('data'))->toHaveCount(Brand::count());
    expect($response->json('data.0'))->toHaveKeys([
        'id', 'name',
    ]);
});

it('Verify if we can see one brand', function () {
    $brand = Brand::inRandomOrder()->first();
    $response = $this->getJson("/api/brands/{$brand->id}");

    expect($response->status())->toBe(200);
    expect($response->json('data.id'))->toBe($brand->id);
    expect($response->json('data.name'))->toBe($brand->name);
});

it('Verify if we reveice an error when try to get an non-existent brand', function () {
    $response = $this->getJson('/api/brands/9999999999');

    expect($response->status())->toBe(404);
});
