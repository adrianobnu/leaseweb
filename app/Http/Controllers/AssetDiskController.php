<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetDiskRequest;
use App\Http\Resources\AssetDiskResource;
use App\Models\Asset;
use Orion\Concerns\DisableAuthorization;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\RelationController;

class AssetDiskController extends RelationController
{
    use DisableAuthorization, DisablePagination;

    /**
     * Fully-qualified model class name
     */
    protected $model = Asset::class;

    /**
     * Name of the relationship as it is defined on the Post model
     */
    protected $relation = 'disks';

    /**
     * @var string
     */
    protected $resource = AssetDiskResource::class;

    /**
     * @var string
     */
    protected $request = AssetDiskRequest::class;
}
