<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetRequest;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use Orion\Concerns\DisableAuthorization;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class AssetController extends Controller
{
    use DisableAuthorization, DisablePagination;

    /**
     * Fully-qualified model class name
     */
    protected $model = Asset::class;

    /**
     * @var string
     */
    protected $resource = AssetResource::class;

    /**
     * @var string
     */
    protected $request = AssetRequest::class;
}
