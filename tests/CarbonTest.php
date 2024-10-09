<?php

namespace Minasm\Tests;

use Exception;
use Minasm\Carbon;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CarbonTest extends TestCase
{
    /**
     * @throws Exception
     */
    #[Test]
    public function getBusinessDaysWithValidDates(): void
    {
        $carbon = new Carbon;
        $startDate = '01/01/2022';
        $endDate = '31/01/2022';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate);
        $this->assertEquals(20, $businessDays);
    }

    #[Test]
    public function getBusinessDaysWithInvalidStartDate(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid start date format. Please use the format matching your date. Default format is : d/m/Y');

        $carbon = new Carbon;
        $startDate = '2022-01-01';
        $endDate = '31/01/2022';
        $carbon->getBusinessDays($startDate, $endDate);

    }

    #[Test]
    public function getBusinessDaysWithInvalidEndDate(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid start date format. Please use the format matching your date. Default format is : d/m/Y');

        $carbon = new Carbon;
        $startDate = '01/01/2022';
        $endDate = '2022-01-31';
        $carbon->getBusinessDays($startDate, $endDate);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function getBusinessDaysWithCustomFormat(): void
    {
        $carbon = new Carbon;
        $startDate = '2023-04-26';
        $endDate = '2023-05-03';
        $format = 'Y-m-d';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(5, $businessDays);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function it_returns_one_day(): void
    {
        $carbon = new Carbon;
        $startDate = '2023-03-23';
        $endDate = '2023-03-23';
        $format = 'Y-m-d';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(1, $businessDays);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function it_handles_same_date_when_hours_provided(): void
    {
        $carbon = new Carbon;
        $startDate = '2023-03-23 08:00:00';
        $endDate = '2023-03-23 17:00:00';
        $format = 'Y-m-d H:i:s';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(1, $businessDays);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function it_should_return_0(): void
    {
        $carbon = new Carbon;
        $startDate = '2023-05-01 00:00:00';
        $endDate = '2023-05-01 00:00:00';
        $format = 'Y-m-d H:i:s';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(0, $businessDays);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function it_should_return_1(): void
    {
        $carbon = new Carbon;
        $startDate = '2023-05-02 00:00:00';
        $endDate = '2023-05-02 00:00:00';
        $format = 'Y-m-d H:i:s';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(1, $businessDays);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function it_should_return_2(): void
    {
        $carbon = new Carbon;
        $startDate = '2023-05-01 00:00:00';
        $endDate = '2023-05-03 00:00:00';
        $format = 'Y-m-d H:i:s';
        $businessDays = $carbon->getBusinessDays($startDate, $endDate, $format);
        $this->assertEquals(2, $businessDays);
    }
}
