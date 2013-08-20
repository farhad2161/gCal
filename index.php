<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once './gCal.php';
        require_once './calendar/Gregorian.php';
        require_once './calendar/SolarHijri.php';

        $solarHijri = '1392/05/28 11:01:02';
        echo '<u>Convert Solar Hijri to Gregorian :</u><br>' .
        'Sample Solar Hijri : ' . $solarHijri . '<br>' .
        'Converted to Gregorian : ' .
        gCal::convert('Y/m/d H:i:s', $solarHijri, SolarHijri::calendarName(), 'Y-m-d H:i:s', Gregorian::calendarName()) .
        '<br><br>';

        $gregorian = '2013-08-19 01:00:01';
        echo '<u>Convert Gregorian to Solar Hijri  :</u><br>' .
        'Sample Gregorian : ' . $gregorian . '<br>' .
        'Converted to Solar Hijri : ' .
        gCal::convert('Y-m-d H:i:s', $gregorian, Gregorian::calendarName(), 'Y/m/d H:i:s', SolarHijri::calendarName()) .
        '<br><br>';
        ?>
    </body>
</html>
