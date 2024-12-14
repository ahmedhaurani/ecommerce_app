<?php
// if (!function_exists('locale_route')) {
//     function locale_route($name, $parameters = [], $absolute = true) {
//         // Ensure 'locale' is added to the parameters
//         $parameters = array_merge(['locale' => app()->getLocale()], $parameters);
//         return route($name, $parameters, $absolute);
//     }
// }
if (!function_exists('locale_route')) {
    function locale_route($name, $parameters = [], $absolute = true) {
        // Merge the locale into the route parameters
        $parameters = array_merge(['locale' => app()->getLocale()], $parameters);
        return route($name, $parameters, $absolute);
    }
}

if (!function_exists('locale_redirect')) {
    function locale_redirect($routeName, $parameters = [])
    {
        $parameters['locale'] = app()->getLocale();
        return redirect()->route($routeName, $parameters);
    }
}

// if (!function_exists('locale_route')) {
//     function locale_route($name, $parameters = [], $absolute = true) {
//         $parameters = array_merge(['locale' => app()->getLocale()], $parameters);
//         return route($name, $parameters, $absolute);
//     }
// }
