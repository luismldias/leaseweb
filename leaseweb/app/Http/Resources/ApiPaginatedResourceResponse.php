<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

class ApiPaginatedResourceResponse extends PaginatedResourceResponse
{

    /**
     * Sets the meta information for the pagination
     *
     * @param mixed $paginated
     * @return array
     */
    protected function meta($paginated): array
    {
        $metaData = parent::meta($paginated);
        return [
            'current_page' => $metaData['current_page'] ?? null,
            'total_items'  => $metaData['total'] ?? null,
            'per_page'     => $metaData['per_page'] ?? null,
            'total_pages'  => $metaData['last_page'] ?? null,
        ];
    }

    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function paginationInformation($request)
    {
        $paginated = $this->resource->resource->toArray();

        return [
            'pagination' => $this->meta($paginated),
        ];
    }
}