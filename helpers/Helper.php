<?php

class Helper
{
    public static function display($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    // dd = display & die
    public static function dd($data)
    {
        Helper::display($data);
        die();
    }

    public static function key_sort(&$a, $k)
    {
        $cmp = function($a, $b) use ($k) {
            return (strcmp($a[$k], $b[$k]));
        };

        usort($a, $cmp);
    }
}
