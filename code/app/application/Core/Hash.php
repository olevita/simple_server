<?php

namespace Core;

class Hash
{
    public static function encode(string $string): string
    {
        return md5($string);
    }
}