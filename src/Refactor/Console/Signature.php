<?php
namespace Refactor\Console;

/**
 * Class Signature
 * @package Refactor\Console
 */
class Signature
{
    private static $logo = '
+---------------------------------------+
| Hand coded with %s by Rick in t Veld   |
|            rick.in.t.veld@opinity.nl  |
+---------------------------------------+
        \   ^__^
         \  (oo)\_______
            (__)\       )\/\
                ||----w |
                ||     ||';

    /**
     * @return string
     */
    public static function write(): string
    {
        return sprintf(self::$logo, '♥');
    }
}
