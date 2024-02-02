<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Orion\Concerns\DisableAuthorization;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class BrandController extends Controller
{
    use DisableAuthorization, DisablePagination;

    /**
     * Fully-qualified model class name
     */
    protected $model = Brand::class;

    /**
     * @var string
     */
    protected $resource = BrandResource::class;
}
