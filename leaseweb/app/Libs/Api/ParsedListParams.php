<?php

namespace App\Libs\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Takes the parameters received by the Api get requests and transforms them into an object
 */
class ParsedListParams
{

    /**
     * An array containing the original data that was applied
     * @var array $filters
     */
    public array $originalData    = [];

    /**
     * The field to be used in the ordering of the items
     * @var string $orderBy
     */
    public string $orderBy        = 'id';

    /**
     * The direction for the list sorting
     * @var string $orderDirection
     */
    public string $orderDirection = 'ASC';

    /**
     * An array containing the filters list to apply
     * @var array $filters
     */
    public array $filters         = [];

    /**
     * The page number to list. defaults to 1
     * @var int $pageNumber
     */
    public int $pageNumber        = 1;

    /**
     * The number of items to include in a page. Defaults to the api.default_items_per_page config (10)
     * @var int $itemsPerPage
     */
    public int $itemsPerPage;

    /**
     * Class constructor
     *
     * @param array $requestData
     * @return void
     */
    public function __construct(array $requestData)
    {
        $this->originalData   = $requestData;
        $this->pageNumber     = $this->getPageNumber();
        $this->itemsPerPage   = $this->getItemsPerPage();
        $this->orderBy        = $this->getOrderBy();
        $this->orderDirection = $this->getOrderDirection();
        $this->filters        = $requestData['filter'] ?? $requestData['filter'] ?? [];
    }

    /**
     * Gets the page number based on the existance of the parameters
     * @return int
     */
    private function getPageNumber(): int
    {
        return isset($this->originalData['paging']['page']) ? $this->originalData['paging']['page'] : 1;
    }

    /**
     * Gets the number of items based on the parameters
     * @return int
     */
    private function getItemsPerPage(): int
    {
        return isset($this->originalData['paging']['items_per_page'])
            ? $this->originalData['paging']['items_per_page']
            :  config('api.default_items_per_page');
    }

    /**
     * Gets direction for the sorting of the items
     * @return string
     */
    private function getOrderDirection(): string
    {
        return isset($this->originalData['order']['direction'])
            ? $this->originalData['order']['direction']
            : 'asc';
    }

    /**
     * Gets the default field to which order the records, defaults to id
     * @return string
     */
    private function getOrderBy(): string
    {
        return isset($this->originalData['order']['by'])
            ? $this->originalData['order']['by']
            : 'model';
    }



    /**
     * Gets the default validation data to be used in the Api Form List Requests
     *
     * @param FormRequest $formRequest
     * @return array
     */
    public static function getDefaultApiListRequestValidationData(FormRequest $formRequest): array
    {
        return [
            'paging' => $formRequest->input('paging'),
            'filter' => $formRequest->input('filter'),
            'order'  => $formRequest->input('order'),
            'q'     => $formRequest->input('q'),
        ];
    }

    /**
     * Gets the default validation data to be used in the Api Form List Requests
     *
     * @return array
     */
    public static function getDefaultApiListRequestRules(): array
    {
        return [
            'filter'                => 'nullable',
            'paging.items_per_page' => 'sometimes|int|min:1|max:200',
            'paging.page'           => 'sometimes|int|min:1',
            'order.by'              => 'sometimes|in:name',
            'order.direction'       => 'sometimes|in:asc,desc',
        ];
    }

    /**
     * Gets the default validation data to be used in the Api Form List Requests
     *
     * @return array
     */
    public static function getDefaultApiListFilters(): array
    {
        return [];
    }
}