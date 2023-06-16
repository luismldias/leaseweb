<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\V1\AppEntryContentResource;
use App\Http\Resources\AppStructureResource;

use App\Services\ServerDataService;
use App\Http\Resources\ServerCollection;

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

        $initialList = $this->dataService->list();
        $filters     = [
            'ram' => $this->dataService->getRamValues(),
        ];
       
        $data = [
            'filters'      => $filters,
            'initial_list' => new ServerCollection($initialList),
        ];

        return new AppStructureResource($data);
    }

    


}
