<?php
namespace App\Imports;

use Maatwebsite\Excel\Row;
use Exception;
use App\Models\Location;
use Maatwebsite\Excel\Concerns\OnEachRow;
use App\Models\Server;
use App\Helpers\ImportServersHelper;

class ServersFirstSheetImport implements OnEachRow
{

    protected static $locations = [];
    

    /**
     * @param  Row  $row
     */
    public function onRow(Row $row)
    {
        try{
            $rowIndex = $row->getIndex();
            $row      = $row->toArray();

            if ($row[0] === 'Model'){
                //This is the title row, returning
                return;
            }
            $modelRaw    = $row[0];
            $ramRaw      = $row[1];
            $storageRaw  = $row[2];
            $locationRaw = $row[3];
            $priceRaw    = $row[4];
    
   
            //identify the location from the class structure
            $locationId = array_search($locationRaw, self::$locations);

            if (!$locationId){
                //no location found, we need to create it 
                $location = Location::create([
                    'name' => $locationRaw
                ]);
                $location->save();
                $locationId = $location->id;
                self::$locations[$locationId] = $locationRaw;
            } 

            //get the hdd structured information
            $hddInfo = ImportServersHelper::getHddStructure($storageRaw);
            if (empty($hddInfo)){
                dump('Error in '. $storageRaw .' : empty hdd structure' );
                //TODO - Log Error
                return;
            }

           

            $serverData = [
                'location_id'    => $locationId,
                'model'          => $modelRaw,
                'hash'           => md5($modelRaw),
                'ram_info'       => $ramRaw,
                'ram_value'      => ImportServersHelper::getRamSize($ramRaw),
                'hdd_info'       => $storageRaw,
                'hdd_size_in_mb' => $hddInfo['capacityMb'],
                'hdd_type'       => $hddInfo['type'],
                'price'          => $priceRaw,
            ];                 
            $server =  new Server($serverData);
            $server->save();
        }catch(Exception $e){
            //TODO - Log Error
            dump('Error in '. $modelRaw .' : ' . $e->getMessage());
            dump($storageRaw, ImportServersHelper::getHddStructure($storageRaw), $serverData);

        }
    }



    

    
}