<?php

namespace App\Utils;

class StringUtils
{
    public static function mb_includes($str, $subst) {
        return mb_strpos($str, $subst) !== false;
    }

    public static function mb_replace($str, $substr, $replacement) {
        $parts = mb_split(preg_quote($substr), $str);
        return implode($replacement, $parts);
    }

    public static function mb_replace_first($str, $substr, $replacement) {
        $pos = mb_strpos($str, $substr);
        if ($pos === false) {
            return $str;
        }
        return StringUtils::mb_substr_replace($str, $replacement, $pos, mb_strlen($substr));
    }

    public static function mb_substr_replace($original, $replacement, $position, $length)
    {
        $startString = mb_substr($original, 0, $position, 'UTF-8');
        $endString = mb_substr($original, $position + $length, mb_strlen($original), 'UTF-8');
        return $startString . $replacement . $endString;
    }

    /**
     * utf8_split() is the same as str_split(), but also works for special (e.g. chinese) characters
     *
     * @param string $str
     * @return string[]
     */
    public static function utf8_split($str) {
        return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
    }
}