<?php

namespace Minasm;

use DateInterval;
use DatePeriod;
use DateTime;
use Exception;

class Carbon extends \Citco\Carbon
{
    private static $cachedBusinessDays = [];

    public function getBusinessDays($start, $end, string $format = 'd/m/Y', string $country = 'UK'): int
    {
        //convert to DateTime if string date received other wise clone datetime object to make input immutable
        $startDate = $start instanceof DateTime ? (clone $start) :
            DateTime::createFromFormat($format, $start);
        $endDate = $end instanceof DateTime ? clone $end : DateTime::createFromFormat($format, $end);

        if (! $startDate) {
            throw new Exception('Invalid start date format. Please use the format matching your date. Default format is : '.$format);
        }
        if (! $endDate) {
            throw new Exception('Invalid start date format. Please use the format matching your date. Default format is : '.$format);
        }
        $startDate=$startDate->setTime(0, 0, 0);
        $endDate=$endDate->setTime(23, 59, 59);

        //initialize cache as array
        if (empty(self::$cachedBusinessDays)) {
            self::$cachedBusinessDays = [];
        }

        //create cache key
        $cacheKey = $startDate->format('Y-m-d').$endDate->format('Y-m-d');

        //if same interval requested again resturn from cache instead
        if (array_key_exists($cacheKey, self::$cachedBusinessDays)) {
            return self::$cachedBusinessDays[$cacheKey];
        }

        $interval = new DateInterval('P1D');

        $dateRange = new DatePeriod(  $startDate, $interval, (clone $endDate));
        $holidays = array_keys((new Carbon())->getBankHolidays([new Carbon($startDate), new Carbon($endDate)]));

        $holidays = array_map(function ($item) use ($format) {
            return DateTime::createFromFormat('Y-m-d', $item)->format('Y-m-d');
        }, $holidays);
        self::$cachedBusinessDays[$cacheKey] = 0;
         foreach ($dateRange as $date) {
            if ($date->format('N') < 6 && ! in_array($date->format('Y-m-d'), $holidays)) {
                self::$cachedBusinessDays[$cacheKey]++;
            }
        }

        return self::$cachedBusinessDays[$cacheKey];
    }
}
