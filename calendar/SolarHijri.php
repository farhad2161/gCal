<?php

/**
 * This class will convert Solar Hijri to unix and vise versa.
 * @notice This class has so many bugs at this time.
 *
 * @author Farhad Kia
 * @email farhad2161@yahoo.com
 */
class SolarHijri extends BaseCalendar {

    /**
     * Covert Solar Hijri date to Unix time stamp.
     * @param string $format format of date string.
     * @param string $date A date for convert to Unix timestamp.
     * @return int return Unix timestamp.
     */
    public function convertToUnixTimeStamp($format, $date) {
        return self::shDateDifference($format, $date, 'Y-m-d H:i:s', '1348-10-11 01:00:00');
    }

    /**
     * Revert timestamp to Solar Hijri date.
     * @param string $format format of returning result.
     * @param string $timestamp Unix timestamp.
     * @return string return date in given format.
     */
    public function revertFromUnixTimeStamp($format, $timestamp) {

        $year = 1348;
        $month = 10;
        $day = 11;
        $hour = 1;
        $minute = 0;
        $second = 0;

        $timestamp = $timestamp - (22 * 60 * 60) - ((30 + 29 + 19) * 24 * 60 * 60);
        $year = 1349;
        $month = 1;
        $day = 1;
        $hour = 0;
        $minute = 0;
        $second = 0;

        while ($timestamp > 0) {
            $availableSecond = self::shYearDayCount($year) * 24 * 60 * 60;
            if ($timestamp < $availableSecond) break;
            $year++;
            $timestamp-=$availableSecond;
        }

        while ($timestamp > 0) {
            $availableSecond = self::shMonthDayCount($month, $year) * 24 * 60 * 60;
            if ($timestamp < $availableSecond) break;
            $month++;
            if ($month > 12) {
                $year++;
                $month = 1;
            }
            $timestamp-=$availableSecond;
        }

        while ($timestamp > 0) {
            $availableSecond = 24 * 60 * 60;
            if ($timestamp < $availableSecond) break;
            $day++;
            if ($day > self::shMonthDayCount($month, $year)) {
                $month++;
                if ($month > 12) {
                    $year++;
                    $month = 1;
                }
                $day = 1;
            }
            $timestamp-=$availableSecond;
        }

        while ($timestamp > 0) {
            $availableSecond = 60 * 60;
            if ($timestamp < $availableSecond) break;
            $hour++;
            if ($hour > 23) {
                $day++;
                if ($day > self::shMonthDayCount($month, $year)) {
                    $month++;
                    if ($month > 12) {
                        $year++;
                        $month = 1;
                    }
                    $day = 1;
                }
                $hour = 0;
            }
            $timestamp-=$availableSecond;
        }

        while ($timestamp > 0) {
            $availableSecond = 60;
            if ($timestamp < $availableSecond) break;
            $minute++;
            if ($minute > 59) {
                $hour++;
                if ($hour > 23) {
                    $day++;
                    if ($day > self::shMonthDayCount($month, $year)) {
                        $month++;
                        if ($month > 12) {
                            $year++;
                            $month = 1;
                        }
                        $day = 1;
                    }
                    $hour = 0;
                }
                $minute = 0;
            }
            $timestamp-=$availableSecond;
        }

        while ($timestamp > 0) {
            $availableSecond = 1;
            if ($timestamp < $availableSecond) break;
            $second++;
            if ($second > 59) {
                $minute++;
                if ($minute > 59) {
                    $hour++;
                    if ($hour > 23) {
                        $day++;
                        if ($day > self::shMonthDayCount($month, $year)) {
                            $month++;
                            if ($month > 12) {
                                $year++;
                                $month = 1;
                            }
                            $day = 1;
                        }
                        $hour = 0;
                    }
                    $minute = 0;
                }
                $second = 0;
            }
            $timestamp-=$availableSecond;
        }

        if ($minute < 10) $minute = '0' . $minute;
        if ($second < 10) $second = '0' . $second;
        $date = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minute . ':' . $second;
        $date = DateTime::createFromFormat('Y-n-j G:i:s', $date);
        return $date->format($format);
    }

    /**
     * Calculate differnce between to Solar Hijiri date in second
     * @param string $format1 first date format string
     * @param string $date1 first date
     * @param string $format2 second date format string
     * @param string $date2 second date
     * @return int diffirence in second
     */
    static function shDateDifference($format1, $date1, $format2, $date2) {
        $total_day = $year_day = $month_day = $day = $date1_month_day = $date2_month_day =
                $date1_day = $date2_day = $hour = $minute = $second = $hour1 = $minute1 = $second1 =
                $hour2 = $minute2 = $second2 = 0;

        $date1 = date_parse_from_format($format1, $date1);
        $date2 = date_parse_from_format($format2, $date2);

        if ($date1['second'] === FALSE) $date1['second'] = 0;
        if ($date2['second'] === FALSE) $date2['second'] = 0;

        if ($date1['year'] > $date2['year']) {
            //Year Gap
            for ($i = $date2['year'] + 1; $i < $date1['year']; $i++) {
                $year_day+=self::shYearDayCount($i);
            }
            //Month Gap
            for ($i = 1; $i < $date1['month']; $i++) {
                $month_day+=self::shMonthDayCount($i, $date1['year']);
            }
            for ($i = $date2['month'] + 1; $i <= 12; $i++) {
                $month_day+=self::shMonthDayCount($i, $date2['year']);
            }
            //Day Gap
            for ($i = 1; $i < $date1['day']; $i++) {
                $day+=1;
            }
            for ($i = $date2['day'] + 1; $i <= self::shMonthDayCount($date2['month'], $date2['year']); $i++) {
                $day+=1;
            }
            //Hour Gap
            for ($i = 0; $i < $date1['hour']; $i++) {
                $hour+=1;
            }
            for ($i = $date2['hour'] + 1; $i <= 23; $i++) {
                $hour+=1;
            }
            //Minute Gap
            for ($i = 0; $i < $date1['minute']; $i++) {
                $minute+=1;
            }
            for ($i = $date2['minute'] + 1; $i <= 59; $i++) {
                $minute+=1;
            }
            //Second Gap
            for ($i = 0; $i < $date1['second']; $i++) {
                $second+=1;
            }
            for ($i = $date2['second']; $i <= 59; $i++) {
                $second+=1;
            }

            $total_day = $year_day + $month_day + $day;
        } else if ($date1['year'] < $date2['year']) {
            //Year Gap
            for ($i = $date1['year'] + 1; $i < $date2['year']; $i++) {
                $year_day+=self::shYearDayCount($i);
            }
            //Month Gap
            for ($i = 1; $i < $date2['month']; $i++) {
                $month_day+=self::shMonthDayCount($i, $date2['year']);
            }
            for ($i = $date1['month'] + 1; $i <= 12; $i++) {
                $month_day+=self::shMonthDayCount($i, $date1['year']);
            }
            //Day Gap
            for ($i = 1; $i < $date2['day']; $i++) {
                $day+=1;
            }
            for ($i = $date1['day'] + 1; $i <= self::shMonthDayCount($date1['month'], $date1['year']); $i++) {
                $day+=1;
            }
            //Hour Gap
            for ($i = 0; $i < $date2['hour']; $i++) {
                $hour-=1;
            }
            for ($i = $date1['hour'] + 1; $i <= 23; $i++) {
                $hour-=1;
            }
            //Minute Gap
            for ($i = 0; $i < $date2['minute']; $i++) {
                $minute-=1;
            }
            for ($i = $date1['minute'] + 1; $i <= 59; $i++) {
                $minute-=1;
            }
            //Second Gap
            for ($i = 0; $i < $date2['second']; $i++) {
                $second-=1;
            }
            for ($i = $date1['second']; $i <= 59; $i++) {
                $second-=1;
            }

            $total_day = ($year_day + $month_day + $day) * (-1);
        } else if ($date1['year'] == $date2['year']) {
            //Month Gap
            for ($i = 1; $i < $date1['month']; $i++) {
                $date1_month_day+=self::shMonthDayCount($i, $date1['year']);
            }
            for ($i = 1; $i < $date2['month']; $i++) {
                $date2_month_day+=self::shMonthDayCount($i, $date1['year']);
            }
            //Day Gap
            for ($i = 1; $i < $date1['day']; $i++) {
                $date1_day+=1;
            }
            for ($i = 1; $i < $date2['day']; $i++) {
                $date2_day+=1;
            }
            //Hour Gap
            for ($i = 0; $i < $date1['hour']; $i++) {
                $hour1+=1;
            }
            for ($i = 0; $i < $date2['hour']; $i++) {
                $hour2+=1;
            }
            //Minute Gap
            for ($i = 0; $i < $date1['minute']; $i++) {
                $minute1+=1;
            }
            for ($i = 0; $i < $date2['minute']; $i++) {
                $minute2+=1;
            }
            //Second Gap
            for ($i = 0; $i <= $date1['second']; $i++) {
                $second1+=1;
            }
            for ($i = 0; $i <= $date2['second']; $i++) {
                $second2+=1;
            }

            $hour = $hour1 - $hour2;
            $minute = $minute1 - $minute2;
            $second = $second1 - $second2;
            $total_day = ($date1_month_day + $date1_day ) - ($date2_month_day + $date2_day );
        }

        return ($total_day * 24 * 60 * 60) + ($hour * 60 * 60) + ($minute * 60) + $second;
    }

    /**
     * Return count of days in a specific year. For example if year is a leap year this will return
     * 366 instead of 365.
     * @param int $year Year for get count of days.
     * @return int Return count of days.
     */
    static function shYearDayCount($year) {
        if ($year % 4 == 3) return 366;
        else return 365;
    }

    /**
     * Count of days in a month.
     * @param int $month Month for get count of days
     * @param int $year Month of which year. For example the last month of a leap year has 30 day instead of 29.
     * @return int Return count of days.
     * @throws InvalidArgumentException Month shuld be between 1 and 12.
     */
    static function shMonthDayCount($month, $year) {
        if ($month >= 1 && $month <= 6) return 31;
        else if ($month >= 7 && $month <= 11) return 30;
        else if ($month == 12) {
            if ($year % 4 == 3) return 30;
            else return 29;
        }
        throw new InvalidArgumentException('Month should be between 1 and 12. ' . $month . ' is invalid.');
    }

}

?>