<?php

namespace App\Http\Middleware;

use App\HolidayCalendar;
use Closure;

class CheckHoliday
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $is_holiday = HolidayCalendar::where(['holiday' => date('Y-m-d')])->first();

        if ($is_holiday) {
            return response()->json(['message' => 'Данный запрос доступен только в рабочие дни'],403);
        }

        return $next($request);
    }
}
