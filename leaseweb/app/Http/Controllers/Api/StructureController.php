<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\AppStructureResource;
use App\Services\ServerDataService;

class StructureController extends ApiController
{

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct(ServerDataService $serverDataService)
    {

        $this->dataService = $serverDataService;
    }

    /**
     * Gets a structure of information required for the App
     * GET api/structure
     * 
     * @return AppStructureResource
     */
    public function index(): AppStructureResource
    {

        $filters     = [
            'ram'       => $this->dataService->getRamValues(),
            'hdd_types' => $this->dataService->getHddTypes(),
            'locations' => $this->dataService->getLocations(),
            'hdd_sizes' => $this->dataService->getHddSizes(),
        ];
       
        $data = [
            'filters'      => $filters,
        ];

        return new AppStructureResource($data);
    }

    


}
