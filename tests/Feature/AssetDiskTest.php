<?php

use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Verify if we can add an disk to the asset', function () {
    Asset::factory(5)->create()->each(function ($asset) {
        $response = $this->postJson("/api/assets/{$asset->id}/disks", [
            'size' => 128,
            'type' => 'HDD',
        ]);

        expect($response->status())->toBe(201);
        expect($response->json('data'))->toHaveKeys(['size', 'type']);
        expect($response->json('data.size'))->toBe(128);
        expect($response->json('data.type'))->toBe('HDD');
    });
});

it('Verify if we cannot add an disk without correct data', function () {
    $asset = Asset::factory()->create();
    $response = $this->postJson("/api/assets/{$asset->id}/disks", [
        'any' => 'data',
    ]);

    expect($response->status())->toBe(422);
    expect($response->json('message'))->toBe('The size field is required. (and 1 more error)');
    expect($response->json('errors'))->toHaveKeys(['size', 'type']);
});

it('Verify if we can add an disk with the correct data', function () {
    $asset = Asset::factory()->create();
    $response = $this->postJson("/api/assets/{$asset->id}/disks", [
        'size' => 128,
        'type' => 'SSD',
    ]);

    expect($response->status())->toBe(201);
    expect($response->json('data'))->toHaveKeys(['size', 'type']);
    expect($response->json('data.size'))->toBe(128);
    expect($response->json('data.type'))->toBe('SSD');
});

it('Verify if we can update an disk', function () {
    $asset = Asset::factory()->create();

    $disk = $asset->disks()->create([
        'size' => 128,
        'type' => 'HDD',
    ]);

    $response = $this->putJson("/api/assets/{$asset->id}/disks/{$disk->id}", [
        'size' => 256,
        'type' => 'SSD',
    ]);

    expect($response->status())->toBe(200);
    expect($response->json('data'))->toHaveKeys(['size', 'type']);
    expect($response->json('data.size'))->toBe(256);
    expect($response->json('data.type'))->toBe('SSD');
});

it('Verify if we can delete an disk', function () {
    $asset = Asset::factory()->create();
    $disk = $asset->disks()->create([
        'size' => 128,
        'type' => 'HDD',
    ]);

    $response = $this->deleteJson("/api/assets/{$asset->id}/disks/{$disk->id}");

    expect($response->status())->toBe(200);
});
