<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\ServersFirstSheetImport;

class ImportServers implements WithMultipleSheets 
{

    public function sheets(): array
    {
        return [
            new ServersFirstSheetImport(),
        ];
    }
    
}
