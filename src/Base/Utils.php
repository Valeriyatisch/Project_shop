<?php


namespace Val\SweetsShop\Base;


class Utils
{
    public static function generateSessionId(){
        $num = md5(uniqid(rand(),1));
        return $num;
    }
}