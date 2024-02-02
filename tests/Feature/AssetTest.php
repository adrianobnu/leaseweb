<?php

use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Verify if a new asset is created and returned correctly', function () {
    Asset::factory(15)->create([
        'price' => 1000,
    ])->each(function ($asset) {
        $response = $this->getJson("/api/assets/{$asset->id}");

        expect($response->status())->toBe(200);
        expect($response->json('data'))->toHaveKeys(['id', 'name', 'code', 'price', 'memories', 'disks', 'brand']);
        expect($response->json('data.id'))->toBe($asset->id);
        expect($response->json('data.name'))->toBe($asset->name);
        expect($response->json('data.code'))->toBe($asset->code);
        expect($response->json('data.price'))->toBe(1000);
        expect($response->json('data.brand.id'))->toBe($asset->brand_id);
    });
});

it('Verify if we cannot add an asset without correct data', function () {
    $response = $this->postJson('/api/assets/', [
        'any' => 'data',
    ]);

    expect($response->status())->toBe(422);
    expect($response->json('message'))->toBe('The name field is required. (and 3 more errors)');
    expect($response->json('errors'))->toHaveKeys(['name', 'code', 'price', 'brand_id']);
});

it('Verify if we can add an asset with the correct data', function () {
    $response = $this->postJson('/api/assets/', [
        'name' => 'Test',
        'code' => 123456,
        'price' => 100,
        'brand_id' => 1,
    ]);

    expect($response->status())->toBe(201);
    expect($response->json('data'))->toHaveKeys(['id', 'name', 'code', 'price', 'memories', 'disks', 'brand']);
    expect($response->json('data.name'))->toBe('Test');
    expect($response->json('data.code'))->toBe(123456);
    expect($response->json('data.price'))->toBe(100);
    expect($response->json('data.brand.id'))->toBe(1);
});

it('Verify if we can update an asset with the correct data', function () {
    $asset = Asset::factory()->create();
    $response = $this->putJson("/api/assets/{$asset->id}", [
        'name' => 'Test 2',
        'code' => 102030,
        'price' => 1,
        'brand_id' => 2,
    ]);

    expect($response->status())->toBe(200);
    expect($response->json('data'))->toHaveKeys(['id', 'name', 'code', 'price', 'memories', 'disks', 'brand']);
    expect($response->json('data.name'))->toBe('Test 2');
    expect($response->json('data.code'))->toBe(102030);
    expect($response->json('data.price'))->toBe(1);
    expect($response->json('data.brand.id'))->toBe(2);
});

it('Verify if we cannot update an asset without correct data', function () {
    $asset = Asset::factory()->create();
    $response = $this->putJson("/api/assets/{$asset->id}", [
        'any' => 'data',
    ]);
    expect($response->status())->toBe(422);
    expect($response->json('message'))->toBe('The name field is required. (and 3 more errors)');
    expect($response->json('errors'))->toHaveKeys(['name', 'code', 'price', 'brand_id']);
});

it('Verify if we can delete an asset', function () {
    $asset = Asset::factory()->create();
    $response = $this->deleteJson("/api/assets/{$asset->id}");
    expect($response->status())->toBe(200);
});

it('Verify if we reveice an error when try to get an non-existent asset', function () {
    $response = $this->getJson('/api/assets/9999999999');

    expect($response->status())->toBe(404);
});
