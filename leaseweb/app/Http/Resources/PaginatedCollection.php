<?php

namespace App\Http\Resources;

use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ApiPaginatedResourceResponse;
use Illuminate\Http\JsonResponse;

class PaginatedCollection extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return $this->resource instanceof AbstractPaginator
            ? (new ApiPaginatedResourceResponse($this))->toResponse($request)
            : parent::toResponse($request);
    }
}