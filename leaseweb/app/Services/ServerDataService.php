<?php

namespace App\Services;

use App\Models\Server;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\ApiHttpException;
use App\Libs\Api\ParsedListParams;
use Illuminate\Database\Eloquent\Builder;
use App\Services\DataService;
use Illuminate\Support\Facades\DB;
use App\Models\Location;


class ServerDataService extends DataService
{
    /**
     * Gets and filters servers
     *
     * @param ParsedListParams ?$params - Filter and order data
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list(ParsedListParams $params = null): LengthAwarePaginator
    {
        /** @var Builder $query */
        $query = Server::with('location');
      
        if ($params){
            $this->applyQueryParams($query, $params);
            //dd($params, $query->toSql());
            return $query->paginate($params->itemsPerPage, ['*'], 'page', $params->pageNumber);
        }
        return $query->paginate(config('api.default_items_per_page') , ['*'], 'page');
    }

    
    /**
     * Applies the query params and filters
     *
     * @param Builder &$query
     * @param ParsedListParams $params
     * @return void
     */
    private function applyQueryParams(Builder $query, ParsedListParams $params): void
    {
        $orderDirection = $params->orderDirection;
        $orderBy        = $params->orderBy;
        

        //Defaults when no information is provided
        if (!isset($params->originalData['order']['by'])) {
            $orderBy = 'model';
        }
        if (!isset($params->originalData['order']['direction'])) {
            $orderDirection = 'ASC';
        }

        $query->orderBy($orderBy, $orderDirection);

        // Location_id Filter
        if (isset($params->filters['location_id'])) {
            $locationId = $params->filters['location_id'];
            $query->where('location_id', $locationId);
        }

        if (isset($params->filters['storage_from']) && isset($params->filters['storage_to'])) {
            $storage_from = $params->filters['storage_from'];
            $storage_to   = $params->filters['storage_to'];
            $query->whereBetween('hdd_size_in_mb',  [$storage_from, $storage_to]);

        }else{
            if (isset($params->filters['storage_from'])) {
                $storage_from = $params->filters['storage_from'];
                $query->where('hdd_size_in_mb', '>=', $storage_from);
            }
    
            if (isset($params->filters['storage_to'])) {
                $storage_to = $params->filters['storage_to'];
                $query->where('hdd_size_in_mb', '<=', $storage_to);
            }
        }

        if (isset($params->filters['hdd_type'])) {
            $hddType = $params->filters['hdd_type'];
            $query->where('hdd_type', $hddType);
        }

        if (isset($params->filters['ram'])) {
            $ram = $params->filters['ram'];
            $query->where('ram_value', $ram);
        }

    }


    /**
     * Gets all the existing RAM values from the database in an array
     * @return array
     */
    public function getRamValues(): array
    {

        return DB::table('servers')
            ->orderBy('ram_value', 'asc')
            ->select('ram_value')
            ->distinct()
            ->get()
            ->pluck('ram_value')
            ->toArray();
    }

    /**
     * Gets all the existing Hdd types from the database in an array
     * @return array
     */
    public function getHddTypes(): array
    {

        return DB::table('servers')
            ->orderBy('hdd_type', 'asc')
            ->select('hdd_type')
            ->distinct()
            ->get()
            ->pluck('hdd_type')
            ->toArray();
    }

    /**
     * Gets all the existing locations from the database in an array
     * @return array
     */
    public function getLocations(): array
    {
        return Location::orderBy('name', 'asc')->get()->keyBy('id')->toArray();
        
    }


}