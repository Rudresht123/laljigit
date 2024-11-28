<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
    /**
     * Format a date.
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    function formatDate($date, $format = 'Y-m-d H:i:s')
    {
        return Carbon::parse($date)->format($format);
    }
}
