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

    /** @test **/
    public function it_returns_one_day()
    {
        $carbon = new Carbon();
        $startDate = '2023-03-23';
        $endDate = '2023-03-23';
        $format = 'Y-m-d';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(1, $businessDays);
    }

    public function it_handles_same_date_when_hours_provided()
    {
        $carbon = new Carbon();
        $startDate = '2023-03-23 08:00:00';
        $endDate = '2023-03-23 17:00:00';
        $format = 'Y-m-d H:i:s';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(1, $businessDays);
    }

    /** @test **/
    public function it_should_return_0()
    {
        $carbon = new Carbon();
        $startDate = '2023-05-01 00:00:00';
        $endDate = '2023-05-01 00:00:00';
        $format = 'Y-m-d H:i:s';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(0, $businessDays);
    }
    /** @test **/
    public function it_should_return_1()
    {
        $carbon = new Carbon();
        $startDate = '2023-05-02 00:00:00';
        $endDate = '2023-05-02 00:00:00';
        $format = 'Y-m-d H:i:s';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(1, $businessDays);
    }
    /** @test **/
    public function it_should_return_2()
    {
        $carbon = new Carbon();
        $startDate = '2023-05-01 00:00:00';
        $endDate = '2023-05-03 00:00:00';
        $format = 'Y-m-d H:i:s';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(2, $businessDays);
    }
}
