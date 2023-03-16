<?php 
    namespace Minasm;

    use DateTime;
    use DateInterval;
    use DatePeriod;

    class Carbon extends \Citco\Carbon {
        public function getBusinessDays($start, $end, string $format='d/m/Y', string $country='UK') : int
        {
            $startDate = DateTime::createFromFormat($format, $start);
            $endDate = DateTime::createFromFormat($format, $end);
            $interval = new DateInterval('P1D');
            $dateRange = new DatePeriod($startDate, $interval, $endDate->add($interval)); 
            $holidays = array_keys((new Carbon())->getBankHolidays([new Carbon($start),new Carbon($end)]));
            
            $businessDays = 0;
            foreach ($dateRange as $date) {                
                if($date->format('N') < 6 && !in_array($date->format($format),$holidays)) {
                    ++$businessDays;
                }
            }
            
            return $businessDays;
        }
    
    }