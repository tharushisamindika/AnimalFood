<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format a number as currency with Rs. symbol
     *
     * @param float $amount
     * @param int $decimals
     * @return string
     */
    public static function format($amount, $decimals = 2)
    {
        return 'Rs. ' . number_format($amount, $decimals);
    }

    /**
     * Format a number as currency without symbol (just the formatted number)
     *
     * @param float $amount
     * @param int $decimals
     * @return string
     */
    public static function formatNumber($amount, $decimals = 2)
    {
        return number_format($amount, $decimals);
    }

    /**
     * Get the currency symbol
     *
     * @return string
     */
    public static function symbol()
    {
        return 'Rs.';
    }
}
