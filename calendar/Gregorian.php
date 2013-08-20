<?php

require_once 'BaseCalendar.php';

/**
 * Gregorian calendar required methods for converting and reverting to or from Millenium(2000-01-01)
 *
 * @author Farhad Kia
 */
class Gregorian extends BaseCalendar {

    public function gapUntilMillenium($year, $month, $day) {
        $datetime1 = date_create('2000-01-01');
        $datetime2 = date_create(str_pad($year, 4, '0', STR_PAD_LEFT) . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT));
        $interval = date_diff($datetime1, $datetime2);
        return (int) $interval->format('%R%a');
    }

    public function revertFromMillenium($daysUntilMillenium) {
        $date = new DateTime('2000-01-01');
        if ($daysUntilMillenium >= 0) $date->add(new DateInterval('P' . $daysUntilMillenium . 'D')); // P1D means a period of 1 day
        else $date->sub(new DateInterval('P' . ($daysUntilMillenium * -1) . 'D'));
        return date_parse_from_format('Y-m-d', $date->format('Y-m-d'));
    }

}

?>