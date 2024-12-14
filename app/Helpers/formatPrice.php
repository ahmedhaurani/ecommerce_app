<?php

if (!function_exists('formatPrice')) {
    function formatPrice($amount)
    {
        // Check the current locale and format accordingly
        if (app()->isLocale('ar')) {
            return number_format($amount, 0) . ' د.ع';
        } else {
            return number_format($amount, 0) . ' IQD';
        }
    }
}
