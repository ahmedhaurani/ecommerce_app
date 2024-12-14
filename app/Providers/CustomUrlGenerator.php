<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;

class CustomUrlGenerator extends BaseUrlGenerator
{
    public function route($name, $parameters = [], $absolute = true)
    {
        // Automatically add the locale parameter if it's not set
        if (!isset($parameters['locale'])) {
            $parameters['locale'] = app()->getLocale();
        }

        return parent::route($name, $parameters, $absolute);
    }
}
