<?php

use Jenssegers\Date\Date;

function date_formats()
{
    return array(
        'm/d/Y' => array(
            'setting'    => 'm/d/Y',
            'datepicker' => 'mm/dd/yyyy',
        ),
        'm-d-Y' => array(
            'setting'    => 'm-d-Y',
            'datepicker' => 'mm-dd-yyyy',
        ),
        'm.d.Y' => array(
            'setting'    => 'm.d.Y',
            'datepicker' => 'mm.dd.yyyy',
        ),
        'Y/m/d' => array(
            'setting'    => 'Y/m/d',
            'datepicker' => 'yyyy/mm/dd',
        ),
        'Y-m-d' => array(
            'setting'    => 'Y-m-d',
            'datepicker' => 'yyyy-mm-dd',
        ),
        'Y.m.d' => array(
            'setting'    => 'Y.m.d',
            'datepicker' => 'yyyy.mm.dd',
        ),
        'd/m/Y' => array(
            'setting'    => 'd/m/Y',
            'datepicker' => 'dd/mm/yyyy',
        ),
        'd-m-Y' => array(
            'setting'    => 'd-m-Y',
            'datepicker' => 'dd-mm-yyyy',
        ),
        'd.m.Y' => array(
            'setting'    => 'd.m.Y',
            'datepicker' => 'dd.mm.yyyy',
        ),
    );
}

function dbDate($date)
{
    return dateParser($date)->toDateTimeString();
}

function dateElapsed($date)
{
    $dt = Date::parse($date);

    return $dt->diffForHumans();
}

function dateString($date)
{
    $dt = Date::parse($date);

    return $dt->formatLocalized(get_option('date_format'));

    //return $dt->toDateString();
}

function dateTimeString($date)
{
    $dt = Date::parse($date);

    return $dt->formatLocalized(get_option('date_format') . ' %l:%M %p');

    // return $dt->toDateTimeString();
}

function dateFormatted($date)
{
    $dt = Date::parse($date);

    return $dt->formatLocalized(get_option('date_format'));
}

function dateIso8601String($date)
{
    return Date::parse($date)->toIso8601String();
}

function dateTimeFormatted($date)
{
    $dt = Date::parse($date);

    return $dt->toDayDateTimeString();
}

function timelog($str_time)
{
    sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);

    return isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
}

function dateParser($date, $tz = null)
{
    $tz = is_null($tz) ? get_option('timezone') : $tz;
    return Date::parse($date, $tz);
}

function datesMonth($month, $year)
{
    $num         = days_in_month($month, $year);
    $dates_month = array();

    for ($i = 1; $i <= $num; $i++) {
        $mktime          = mktime(0, 0, 0, $month, $i, $year);
        $date            = date("d-m-Y", $mktime);
        $dates_month[$i] = $date;
    }

    return $dates_month;
}

/*
* Returns the number of days in a given month and year, taking into account leap years.
*
* $month: numeric month (integers 1-12)
* $year: numeric year (any integer)
*/
function days_in_month($month, $year)
{
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

/**
 * Adds interval to yyyy-mm-dd date and returns in same format.
 *
 * @param string $date
 * @param int    $days
 *
 * @return string
 */
function incrementDate($date, $days)
{
    $dt = Date::parse($date);

    return $dt->addDays($days)->toDateTimeString();
}

function nextRecurringDate($date, $frequency)
{
    $dt = Date::parse($date);
    $nextDate = checkFutureDate($dt->addDays($frequency), $frequency);
    return $nextDate->toDateTimeString();
}

function checkFutureDate($dt, $frequency)
{
    if ($dt->timestamp < now()->timestamp) {
        return checkFutureDate($dt->addDays($frequency), $frequency);
    }
    return $dt;
}

function dateFromUnix($timestamp)
{
    $dt = Date::createFromTimestamp($timestamp);

    return $dt->formatLocalized('%b %d, %Y %l:%M %p');
}

function dueInDays($due_date)
{
    $created  = Date::parse(date('Y-m-d'));
    $due_date = Date::parse($due_date);

    return $created->diffInDays($due_date);
}

function timePickerFormat($attr)
{
    return Date::parse($attr)->format('d-m-Y h:i A');
}

function datePickerFormat($date)
{
    return Date::parse($date)->format('d-m-Y');
}

function getMonth($date)
{
    $dt = Date::parse($date);

    return $dt->month;
}

function lastMonth()
{
    $dt = new Date('last month');

    return $dt;
}
function diffDays($from, $to = null)
{
    if (is_null($to)) {
        $to = today();
    }
    $dt = Date::parse($from);

    return $dt->diffInDays($to, false);
}

function gmsec($seconds)
{
    $t = round($seconds);

    return sprintf('%02d:%02d:%02d', ($t / 3600), ($t / 60 % 60), $t % 60);
}

/**
 * Timezones list with GMT offset
 *
 * @return array
 */
function timezones()
{
    return \Cache::remember(
        'embase-timezones',
        now()->addDays(5),
        function () {
            $zones_array = array();
            $timestamp   = time();
            foreach (timezone_identifiers_list() as $key => $zone) {
                date_default_timezone_set($zone);
                $zones_array[$zone] = 'UTC/GMT ' . date('P', $timestamp) . ' - ' . $zone;
            }
            return $zones_array;
        }
    );
}

function tz_list()
{
    $timezoneIdentifiers = \DateTimeZone::listIdentifiers();
    $utcTime             = new \DateTime('now', new \DateTimeZone('UTC'));

    $tempTimezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $currentTimezone = new \DateTimeZone($timezoneIdentifier);

        $tempTimezones[] = array(
            'offset'     => (int) $currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier,
        );
    }

    $timezoneList = array();
    foreach ($tempTimezones as $tz) {
        $sign                            = ($tz['offset'] > 0) ? '+' : '-';
        $offset                          = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$tz['identifier']] = 'UTC ' . $sign . $offset . ' - ' .
            $tz['identifier'];
    }

    return $timezoneList;
}

function validateDate($x)
{
    return (date('Y-m-d H:i:s', strtotime($x)) == $x);
}

// Get number of days

function numDays($frequency)
{
    switch ($frequency) {
        case '7D':
            return 7;
            break;
        case '1M':
            return 31;
            break;
        case '3M':
            return 90;
            break;
        case '6M':
            return 182;
            break;
        case '1Y':
            return 365;
            break;
    }
}
