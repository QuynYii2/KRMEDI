<?php


if (!function_exists('locationHelper')) {
    function locationHelper()
    {
        if (Session::get('locale') == null ){
            $locale = 'vi';
        }else{
            $locale = Session::get('locale');
        }
        return $locale;
    }

}
