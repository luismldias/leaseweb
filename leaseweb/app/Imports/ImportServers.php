<?php

namespace App\Imports;

use App\Models\Server;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

use App\Models\Location;
use Exception;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Throwable;
use App\Imports\ServersFirstSheetImport;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class ImportServers implements WithMultipleSheets 
{

    public function sheets(): array
    {
        return [
            new ServersFirstSheetImport(),
        ];
    }
    
}
