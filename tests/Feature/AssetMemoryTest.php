<?php

use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Verify if we can add an memory to the asset', function () {
    Asset::factory(5)->create()->each(function ($asset) {
        $response = $this->postJson("/api/assets/{$asset->id}/memories", [
            'size' => 128,
            'quantity' => 1,
        ]);

        expect($response->status())->toBe(201);
        expect($response->json('data'))->toHaveKeys(['size', 'quantity']);
        expect($response->json('data.size'))->toBe(128);
        expect($response->json('data.quantity'))->toBe(1);
    });
});

it('Verify if we cannot add an memory without correct data', function () {
    $asset = Asset::factory()->create();
    $response = $this->postJson("/api/assets/{$asset->id}/memories", [
        'any' => 'data',
    ]);

    expect($response->status())->toBe(422);
    expect($response->json('message'))->toBe('The size field is required. (and 1 more error)');
    expect($response->json('errors'))->toHaveKeys(['size', 'quantity']);
});

it('Verify if we can add an memory with the correct data', function () {
    $asset = Asset::factory()->create();
    $response = $this->postJson("/api/assets/{$asset->id}/memories", [
        'size' => 128,
        'quantity' => 1,
    ]);

    expect($response->status())->toBe(201);
    expect($response->json('data'))->toHaveKeys(['size', 'quantity']);
    expect($response->json('data.size'))->toBe(128);
    expect($response->json('data.quantity'))->toBe(1);
});

it('Verify if we can update an memory', function () {
    $asset = Asset::factory()->create();

    $memory = $asset->memories()->create([
        'size' => 128,
        'quantity' => 1,
    ]);

    $response = $this->putJson("/api/assets/{$asset->id}/memories/{$memory->id}", [
        'size' => 333,
        'quantity' => 9,
    ]);

    expect($response->status())->toBe(200);
    expect($response->json('data'))->toHaveKeys(['size', 'quantity']);
    expect($response->json('data.size'))->toBe(333);
    expect($response->json('data.quantity'))->toBe(9);
});

it('Verify if we can delete an memory', function () {
    $asset = Asset::factory()->create();
    $memory = $asset->memories()->create([
        'size' => 128,
        'quantity' => 1,
    ]);

    $response = $this->deleteJson("/api/assets/{$asset->id}/memories/{$memory->id}");

    expect($response->status())->toBe(200);
});
