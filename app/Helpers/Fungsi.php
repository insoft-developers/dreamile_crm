<?php

if (!function_exists('formatDuration')) {

    function formatDuration($seconds)
    {
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;

        if ($minutes > 0) {
            return $minutes . ' Menit ' . $seconds . ' Detik';
        }

        return $seconds . ' Detik';
    }
}
