<?php

use App\Models\Asset;

use function Pest\Stressless\stress;

it('has a fast response time with 100 requests during 10 seconds', function () {
    $asset = Asset::factory()->create([
        'price' => 1000,
    ]);

    $result = stress("localhost/api/assets/{$asset->id}")->concurrency(100)->for(10)->seconds();

    expect($result->requests()->duration()->med())->toBeLessThan(100);
});
