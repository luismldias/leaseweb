<?php

namespace app\Helpers;

class ImportServersHelper{

    /**
     * Gets the split HDD information based on the HDD string
     * @param string $storageRaw
     * 
     * @return array
     */
    public static function getHddStructure($storageRaw): array
    {
        $ret      = [];
        $type     = '';
        $count    = 0;
        $capacity = 0;
        $unit     = '';


        if (strpos($storageRaw,'SATA2')){
            $type = 'SATA';
            $storageRaw = str_replace('SATA2','',$storageRaw);
        }elseif (strpos($storageRaw,'SSD')){
            $type = 'SSD';
            $storageRaw = str_replace('SSD','',$storageRaw);
        }elseif (strpos($storageRaw,'SAS')){
            $type = 'SAS';
            $storageRaw = str_replace('SAS','',$storageRaw);
        }else{
            //unexpected type, not processing
            //TODO - Log this occurrence
            return $ret;
        }

        $storageInfo = explode('x',$storageRaw);
        $count       = $storageInfo[0];

        //holds the capacity value and unit at this point
        $capacityInfo = $storageInfo[1];
        $pattern      = "/(\d+)([A-Za-z]+)/";
       
        if(preg_match($pattern,$capacityInfo,$matches)){
            $capacity = $matches[1];
            $unit     = $matches[2];
        }else{
            //Something went wrong here, returning empry array
             //TODO - Log this occurrence
             return $ret;
        }

        //$ret['diskCount']    = $count;
        //$ret['diskCapacity'] = $capacity;
        //$ret['unit']         = $unit;
        $ret['type']       = $type;
        $ret['capacityMb'] = self::getHddCapacityInMb( $count,$capacity ,$unit );

        return $ret;
    }

    
    /**
     * Gets the ram size
     * @param string $ramRaw
    * 
     * @return string
     */
    public static function getRamSize( $ramRaw): String
    {
        $ramStruct = explode('GB',$ramRaw);
        return $ramStruct[0];

    }


    /**
     * Gets the disk size in megabytes
     * @param int $totalDiscs
     * @param int $capacityPerDisk
     * @param string $unit
     * 
     * @return Int
     */
    private static function getHddCapacityInMb( $totalDisks,$capacityPerDisk, $unit): Int
    {
        if ($unit == 'TB'){
            $capacityInMb = 1048576;
        }else{
            $capacityInMb = 1014;
        }

        $capacityInMb = $capacityInMb * $totalDisks * $capacityPerDisk;

        return $capacityInMb;

    }


    
}


