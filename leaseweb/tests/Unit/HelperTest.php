<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\ImportServersHelper;

class HelperTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_ram_size_helper(): void
    {

        $rawValue = '16GBDDR3';
        $expectedValue = '16';
        $outcome = ImportServersHelper::getRamSize($rawValue);
        $this->assertEquals($expectedValue, $outcome);

        
    }
}
