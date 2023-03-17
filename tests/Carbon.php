<?php

use Minasm\Carbon;
use PHPUnit\Framework\TestCase;

class CarbonTest extends TestCase
{
    /** @test **/
    public function getBusinessDaysWithValidDates()
    {
        $carbon = new Carbon();
        $startDate = '01/01/2022';
        $endDate = '31/01/2022';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate);
        $this->assertEquals(20, $businessDays);
    }

    /** @test **/
    public function getBusinessDaysWithInvalidStartDate()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid start date format. Please use the format matching your date. Default format is : d/m/Y');

        $carbon = new Carbon();
        $startDate = '2022-01-01';
        $endDate = '31/01/2022';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate);
    }

    /** @test **/
    public function getBusinessDaysWithInvalidEndDate()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid start date format. Please use the format matching your date. Default format is : d/m/Y');

        $carbon = new Carbon();
        $startDate = '01/01/2022';
        $endDate = '2022-01-31';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate);
    }

    /** @test **/
    public function getBusinessDaysWithCustomFormat()
    {
        $carbon = new Carbon();
        $startDate = '2023-04-26';
        $endDate = '2023-05-03';
        $format = 'Y-m-d';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(5, $businessDays);
    }
}
