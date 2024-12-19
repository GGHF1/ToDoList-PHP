<?php
use Carbon\Carbon;

if (!function_exists('isDeadlineExpired')) {
    /**
     * Check if the deadline is expired based on the current time and grace period.
     *
     * @param  string|null $deadline
     * @return bool
     */
    function isDeadlineExpired($deadline)
    {
        // If no deadline is set, return false (not expired)
        if (!$deadline) {
            return false;
        }

        // Retrieve the deadline from the input
        $deadline = Carbon::parse($deadline)->timezone(config('app.timezone'));

        // Get the current time in the same timezone
        $now = Carbon::now()->timezone(config('app.timezone'));

        // Log the current time and deadline to debug
        \Log::debug("Current time: " . $now->toDateTimeString() . " | Deadline: " . $deadline->toDateTimeString());

        // Get the expiry buffer time from config (in minutes)
        $bufferMinutes = config('time_check.expiry_buffer_minutes', 1);

        // Check if the current time is past the deadline, considering the grace period
        return $now->gt($deadline->addMinutes($bufferMinutes));
    }
}
