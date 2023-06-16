<?php

namespace App\Http\Resources;

use App\Http\Resources\PaginatedCollection;



class ServerCollection extends PaginatedCollection
{

    // For the list items we are using a simplified resource with less information
    public $collects = ServerListItemResource::class;
}