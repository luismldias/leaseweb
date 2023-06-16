<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Libs\Api\ParsedListParams;
use App\Libs\Support\Sanitizer\Traits\SanitizesInput;

class ServerListRequest extends FormRequest
{
    //use SanitizesInput;


    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData(): array
    {
        return ParsedListParams::getDefaultApiListRequestValidationData($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $defaultRules   = ParsedListParams::getDefaultApiListRequestRules();
        $adicionalRules = [
            'order.by'            => 'nullable|string',
            'filter.storage_from' => 'nullable|integer',
            'filter.storage_to'   => 'nullable|integer',
            'filter.location_id'  => 'nullable|integer',
            'filter.hdd_type'     => 'nullable|string',
            'filter.ram'          => 'nullable|integer',
        ];
        return array_replace($defaultRules, $adicionalRules);
    }

    /**
     * Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        $defaultFilters  = ParsedListParams::getDefaultApiListFilters();
        //optional aditional filters to apply
        $adicionalFilters = [
            'filter.location_id'  => 'cast:integer',
            'filter.storage_from' => 'cast:integer',
            'filter.storage_to'   => 'cast:integer',
            'filter.ram'          => 'cast:integer',
        ];
        return array_replace($defaultFilters, $adicionalFilters);
    }
}