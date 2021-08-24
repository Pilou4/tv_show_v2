<?php

namespace App\Service;

class Slugger
{

    public function sluggify($str)
    {
        $str = trim($str);
        $str = str_replace(" ", "-", $str);
        $str = strtolower($str);

        return $str;
    }
}