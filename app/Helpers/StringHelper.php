<?php

namespace App\Helpers;
use Carbon\Carbon;
/**
 * @author Achmad Munandar
 */
class StringHelper
{
    
    public static function toRp($value)
    {
        return 'Rp '.number_format($value, 0, ',', '.');
    }

    public static function formatDate($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    public static function formatCoaNumber($value)
    {
        return substr_replace($value, ' - ', 1, 0);
    }

}