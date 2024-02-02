<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetMemoryRequest;
use App\Http\Resources\AssetMemoryResource;
use App\Models\Asset;
use Orion\Concerns\DisableAuthorization;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\RelationController;

class AssetMemoryController extends RelationController
{
    use DisableAuthorization, DisablePagination;

    /**
     * Fully-qualified model class name
     */
    protected $model = Asset::class;

    /**
     * Name of the relationship as it is defined on the Post model
     */
    protected $relation = 'memories';

    /**
     * @var string
     */
    protected $resource = AssetMemoryResource::class;

    /**
     * @var string
     */
    protected $request = AssetMemoryRequest::class;
}
