<?php

if (!function_exists('fmtBulan')) {
    function fmtBulan($months) {
        if ($months < 1) return 'Kurang dari 1 bulan';
        $years = floor($months / 12);
        $remainingMonths = ceil($months % 12);
        if ($years > 0 && $remainingMonths > 0) return "{$years} tahun {$remainingMonths} bulan";
        if ($years > 0) return "{$years} tahun";
        return "{$remainingMonths} bulan";
    }
}
