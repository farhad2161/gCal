<?php

require_once 'BaseCalendar.php';

/**
 * SolarHijri calendar required methods for converting and reverting to or from Millenium(2000-01-01 equal to 1378-10-11)
 *
 * @author Farhad Kia
 */
class SolarHijri extends BaseCalendar {

    public function gapUntilMillenium($year, $month, $day) {
        //1378-10-11 is equal to 2000-01-01
        return self::shDateDifference($year, $month, $day, 1378, 10, 11);
    }

    public function revertFromMillenium($daysUntilMillenium) {
        //1378-10-11 is equal to 2000-01-01
        $year = 1378;
        $month = 10;
        $day = 11;
        if ($daysUntilMillenium > 0) {
            while ($daysUntilMillenium >= self::shYearDayCount($year)) {
                $daysUntilMillenium-=self::shYearDayCount($year);
                $year++;
            }
            while ($daysUntilMillenium >= self::shMonthDayCount($month, $year)) {
                $daysUntilMillenium-=self::shMonthDayCount($month, $year);
                $month++;
                if ($month > 12) {
                    $month = 1;
                    $year++;
                }
            }
            while ($daysUntilMillenium > 0) {
                $daysUntilMillenium--;
                $day++;
                if ($day > self::shMonthDayCount($month, $year)) {
                    $day = 1;
                    $month++;
                    if ($month > 12) {
                        $month = 1;
                        $year++;
                    }
                }
            }
        } else {
            $daysUntilMillenium*=-1;
            while ($daysUntilMillenium >= self::shYearDayCount($year - 1)) {
                $daysUntilMillenium-=self::shYearDayCount($year - 1);
                $year--;
            }
            while ($daysUntilMillenium >= self::shMonthDayCount($month - 1 == 0 ? 12 : $month - 1, $year)) {
                $daysUntilMillenium-=self::shMonthDayCount($month - 1 == 0 ? 12 : $month - 1, $year);
                $month--;
                if ($month < 1) {
                    $month = 12;
                    $year--;
                }
            }
            while ($daysUntilMillenium > 0) {
                $daysUntilMillenium--;
                $day--;
                if ($day < 1) {
                    $day = self::shMonthDayCount($month - 1 == 0 ? 12 : $month - 1, $year);
                    $month--;
                    if ($month < 1) {
                        $month = 12;
                        $year--;
                    }
                }
            }
        }

        return array('year' => $year, 'month' => $month, 'day' => $day);
    }

    static function shDateDifference($year1, $month1, $day1, $year2, $month2, $day2) {
        $total_day = $year_day = $month_day = $day = $date1_month_day = $date2_month_day = $date1_day = $date2_day = 0;

        if ($year1 > $year2) {
            //Year Gap
            for ($i = $year2 + 1; $i < $year1; $i++) {
                $year_day+=self::shYearDayCount($i);
            }
            //Month Gap
            for ($i = 1; $i < $month1; $i++) {
                $month_day+=self::shMonthDayCount($i, $year1);
            }
            for ($i = $month2 + 1; $i <= 12; $i++) {
                $month_day+=self::shMonthDayCount($i, $year2);
            }
            //Day Gap
            for ($i = 1; $i <= $day1; $i++) {
                $day+=1;
            }
            for ($i = $day2 + 1; $i <= self::shMonthDayCount($month2, $year2); $i++) {
                $day+=1;
            }

            $total_day = $year_day + $month_day + $day;
        } else if ($year1 < $year2) {
            //Year Gap
            for ($i = $year1 + 1; $i < $year2; $i++) {
                $year_day+=self::shYearDayCount($i);
            }
            //Month Gap
            for ($i = 1; $i < $month2; $i++) {
                $month_day+=self::shMonthDayCount($i, $year2);
            }
            for ($i = $month1 + 1; $i <= 12; $i++) {
                $month_day+=self::shMonthDayCount($i, $year1);
            }
            //Day Gap
            for ($i = 1; $i <= $day2; $i++) {
                $day+=1;
            }
            for ($i = $day1 + 1; $i <= self::shMonthDayCount($month1, $year1); $i++) {
                $day+=1;
            }

            $total_day = ($year_day + $month_day + $day) * (-1);
        } else if ($year1 == $year2) {
            //Month Gap
            for ($i = 1; $i < $month1; $i++) {
                $date1_month_day+=self::shMonthDayCount($i, $year1);
            }
            for ($i = 1; $i < $month2; $i++) {
                $date2_month_day+=self::shMonthDayCount($i, $year1);
            }
            //Day Gap
            for ($i = 1; $i < $day1; $i++) {
                $date1_day+=1;
            }
            for ($i = 1; $i < $day2; $i++) {
                $date2_day+=1;
            }

            $total_day = ($date1_month_day + $date1_day ) - ($date2_month_day + $date2_day );
        }

        return $total_day;
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