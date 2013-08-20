<?php

/**
 * Global Calendar Converter
 * This class use reflection to call two methods written in calendar's class.
 * All calendars class should extend BaseCalendar which is an abstract class.
 * According to BaseCalendar class all child class should have two functions :
 * 1- gapUntilMillenium($year, $month, $day)
 * 2- revertFromMillenium($daysUntilMillenium)
 * Then we can convert all calendars to each other.
 *
 * @author Farhad Kia
 */
class gCal {

    /**
     * Convert different calendars type to each other.
     * @param string $sourceFormat source date format.
     * @param string $sourceDate source date.
     * @param string $sourceCalendarName Class name of the source calendar. Call calendarName() from calendar's parent
     * class(BaseCalendar), this static method will return the name of child class.
     * @param string $destinationFormat Converted date will be return with this format.
     * @param string $destinationCalendarName Destination calendar class name. Call calendarName() from calendar's parent
     * class(BaseCalendar), this static method will return the name of child class.
     * @return string Converted date.
     */
    static function convert($sourceFormat, $sourceDate, $sourceCalendarName, $destinationFormat, $destinationCalendarName) {
        //Create new object from source calendar
        $fromCalendarClass = new ReflectionClass($sourceCalendarName);
        $fromCalendar = $fromCalendarClass->newInstanceArgs();

        //Check source date is valid
        if (!$fromCalendar->isValidDate($sourceFormat, $sourceDate)) throw new Exception('Wrong source date.');

        //Convert source date to array and calculate millenium gap
        $sourceDate = $fromCalendar->dateToArray($sourceFormat, $sourceDate);
        $daysUntilMillenium = $fromCalendar->gapUntilMillenium($sourceDate['year'], $sourceDate['month'], $sourceDate['day']);

        //Create new object from destination calendar
        $toCalendarClass = new ReflectionClass($destinationCalendarName);
        $toCalendar = $toCalendarClass->newInstanceArgs();

        //Calculate destination date from millenium gap
        $destinationDate = $toCalendar->revertFromMillenium($daysUntilMillenium, $destinationFormat);
        $destinationDate['hour'] = $sourceDate['hour'];
        $destinationDate['minute'] = $sourceDate['minute'];
        $destinationDate['second'] = $sourceDate['second'];

        //Convert date array to formated date string
        $destinationDate = $toCalendar->ArrayToDate($destinationDate, $destinationFormat);

        //Check destination date is valid
        if (!$toCalendar->isValidDate($destinationFormat, $destinationDate)) throw new Exception('Wrong destination date.');

        return $destinationDate;
    }

    /**
     * Compare two date with each other.
     * @param type $date1 First date for compare.
     * @param type $format1 Format of first date.
     * @param type $date2 Second date for compare with.
     * @param type $format2 Format of second date.
     * @return int If date1 is greater than date2 return 1 else if is smaller then return -1 and if equal return 0.
     */
    static function compareDate($date1, $format1, $date2, $format2) {
        $date1 = date_parse_from_format($format1, $date1);
        $date2 = date_parse_from_format($format2, $date2);
        $diff_year = $date1['year'] - $date2['year'];
        if ($diff_year > 0) return 1; else if ($diff_year < 0) return -1; else if ($diff_year == 0) {

            $diff_month = $date1['month'] - $date2['month'];
            if ($diff_month > 0) return 1; else if ($diff_month < 0) return -1; else if ($diff_month == 0) {

                $diff_day = $date1['day'] - $date2['day'];
                if ($diff_day > 0) return 1; else if ($diff_day < 0) return -1; else if ($diff_day == 0) {

                    $diff_hour = $date1['hour'] - $date2['hour'];
                    if ($diff_hour > 0) return 1; else if ($diff_hour < 0) return -1; else if ($diff_hour == 0) {

                        $diff_minute = $date1['minute'] - $date2['minute'];
                        if ($diff_minute > 0) return 1; else if ($diff_minute < 0) return -1; else if ($diff_minute == 0) {

                            $diff_second = $date1['second'] - $date2['second'];
                            if ($diff_second > 0) return 1; else if ($diff_second < 0) return -1; else if ($diff_second == 0) return 0; //bug in compare am and pm
                        }
                    }
                }
            }
        }
    }

}

?>