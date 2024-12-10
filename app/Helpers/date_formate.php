<?php
use Carbon\Carbon;

if (!function_exists('formatDate')) {
    /**
     * Formats a date into the desired format (default: 'Y-m-d').
     * Returns null for invalid or empty dates.
     *
     * @param string|null $date
     * @param string $format
     * @return string|null
     */
    function formatDate($date = null, $format = 'Y-m-d')
    {
        try {
            // Return null if $date is null or empty
            if (!$date) {
                return null;
            }

            // Parse and format the date
            return Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            // Return null for invalid date formats
            return null;
        }
    }
}
