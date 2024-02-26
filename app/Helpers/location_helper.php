<?php


if (!function_exists('locationHelper')) {
    function locationHelper()
    {
        $locale = Session::get('locale');
        return $locale;
    }

}
