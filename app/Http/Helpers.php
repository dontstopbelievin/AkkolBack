<?php
use Carbon\Carbon;
use \App\HolidayCalendar;

if (!function_exists('holidayDiffInDays'))
{
    function holidayDiffInDays($date1, $date2 = null, $add_days = 0) {
        $dt = Carbon::parse(date('Y-m-d', strtotime($date1)));
        $dt2 = $date2 ? Carbon::parse(date('Y-m-d', strtotime($date2))) : Carbon::parse(date('Y-m-d'));
        $holiday_list = HolidayCalendar::pluck('holiday')->toArray();

        if ($add_days) {
            for ($i = 1; $i <= $add_days; $i++) {
                $dt = $dt->addDay();

                if (in_array($dt->format('Y-m-d'), $holiday_list)) {
                    $add_days++;
                }
            }
        }

        if ($dt->getTimestamp() < $dt2->getTimestamp()) {
            $expired = true;
        }

        $days_diff = $dt->diffInDaysFiltered(function(Carbon $date) use ($holiday_list) {
            return !in_array($date->format('Y-m-d'), $holiday_list);
        }, $dt2);

        return isset($expired) ? -$days_diff : $days_diff;
    }
}

if (!function_exists('log_pro'))
{
    function log_pro($code = 'empty_key', $data = '', $level = 'INFO')
    {
        \App\Log::create([
            'code'     => $code,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'level'   => $level,
            'data' => serialize($data),
            'ip_address' => request()->ip(),
            'browser' => request()->header('User-Agent'),
        ]);
    }

}