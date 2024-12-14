<?php

namespace App\Traits;

trait FormatsPrice
{


//     public function formattedPrice($amount)
// {
//     $symbol = app()->isLocale('ar') ? 'د.ع' : 'IQD'; // Check for RTL (Arabic)
//     return   number_format($amount). ' '. $symbol;
// }

// }

    public function formatPrice($amount)
    {
        // Format the price based on the current locale
        if (app()->isLocale('ar')) { // For Arabic (RTL)
            return  number_format($amount, 0). 'د.ع ' ; // Adjust formatting as needed
        } else { // For English (LTR)
            return number_format($amount, 0). ' IQD' ;
        }
    }

}
