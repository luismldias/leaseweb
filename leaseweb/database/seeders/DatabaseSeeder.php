<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportServers;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //Checks if the excel file exists
        $filename=storage_path("import/LeaseWeb_servers_filters_assignment.xlsx");
        if (!file_exists($filename)){
           $this->command->error("File does not exist: ".$filename);
           return;
        }

        $this->command->info('Resetting servers data'); 
        DB::table('servers')->delete();
        DB::table('locations')->delete();


        $this->command->info('Importing data from '. $filename);


       
        Excel::import(new ImportServers, $filename);
      

        //Checks the database for records, if there are any,
        
        

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
