<?php

namespace Minasm;

use DateInterval;
use DatePeriod;
use DateTime;
use Exception;

/**
 * Class Carbon
 */
class Carbon extends \Citco\Carbon
{
    /**
     * @var array<string, int>
     */
    private static array $cachedBusinessDays = [];

    /**
     * Get the number of business days between two dates.
     *
     * @param  DateTime|string  $start  The start date.
     * @param  DateTime|string  $end  The end date.
     * @param  string  $format  The format of the dates.
     * @param  string  $country  The country to use for holidays (not implemented).
     * @return int The number of business days.
     *
     * @throws Exception If the date format is invalid.
     */
    public function getBusinessDays(string|DateTime $start, string|DateTime $end, string $format = 'd/m/Y', string $country = 'UK'): int
    {
        // Convert to DateTime if string date received otherwise clone DateTime object to make input immutable.
        $startDate = $start instanceof DateTime ? clone $start : DateTime::createFromFormat($format, (string) $start);
        $endDate = $end instanceof DateTime ? clone $end : DateTime::createFromFormat($format, (string) $end);

        if ($startDate === false) {
            throw new Exception('Invalid start date format. Please use the format matching your date. Default format is : '.$format);
        }
        if (! $endDate) {
            throw new Exception('Invalid start date format. Please use the format matching your date. Default format is : '.$format);
        }
        $startDate = $startDate->setTime(0, 0, 0);
        $endDate = $endDate->setTime(23, 59, 59);

        //initialise cache as an array
        if (empty(self::$cachedBusinessDays)) {
            self::$cachedBusinessDays = [];
        }

        //create a cache key
        $cacheKey = $startDate->format('Y-m-d').$endDate->format('Y-m-d');

        //if the same interval requested again resturn from cache instead
        if (array_key_exists($cacheKey, self::$cachedBusinessDays)) {
            return self::$cachedBusinessDays[$cacheKey];
        }

        $interval = new DateInterval('P1D');

        $dateRange = new DatePeriod($startDate, $interval, (clone $endDate));
        $holidays = array_keys((new Carbon)->getBankHolidays([new Carbon($startDate), new Carbon($endDate)]));

        $holidays = array_map(function (int|string $item): string {
            $date = DateTime::createFromFormat('Y-m-d', (string) $item);

            return $date ? $date->format('Y-m-d') : '';
        }, $holidays);

        // Filter out any potentially empty string elements resulting from the map function
        $holidays = array_filter($holidays, fn ($date) => $date !== '');

        self::$cachedBusinessDays[$cacheKey] = 0;
        foreach ($dateRange as $date) {
            if ($date->format('N') < 6 && ! in_array($date->format('Y-m-d'), $holidays, true)) {
                self::$cachedBusinessDays[$cacheKey]++;
            }
        }

        return self::$cachedBusinessDays[$cacheKey];
    }
}
