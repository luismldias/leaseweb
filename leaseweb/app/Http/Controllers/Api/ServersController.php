<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ServerListRequest;
use App\Services\ServerDataService;
use App\Http\Resources\ServerCollection;
use App\Libs\Api\ParsedListParams;

class ServersController extends ApiController
{


    /**
     * Class constructor
     *
     * @param ServerDataService $serverDataService
     * @return void
     */
    public function __construct(ServerDataService $serverDataService)
    {
        $this->dataService = $serverDataService;
    }

    /**
     * Gets the list of servers
     * GET api/servers
     * 
     * @return App\Http\Resources\ServerCollection
     */
    public function index(ServerListRequest $request): ServerCollection
    {
        $data              = $request->validated();
        $parsedListParams  = new ParsedListParams($data);
        $paginatedItems    = $this->dataService->list($parsedListParams);
        return new ServerCollection($paginatedItems);
    }


    
}