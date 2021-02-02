<?php //src/Censurator/Censurator.php

namespace App\Censurator;

class Censurator
{
    public function purify($string)
    {
        // Go fetch list of nasty words from file
        $nasty_words = file(dirname(__FILE__).'/../files/nasty_words.txt', FILE_IGNORE_NEW_LINES);

        foreach ($nasty_words as $word) {
            $stared = str_repeat("*", mb_strlen($word));
            $string = str_ireplace($word, $stared, $string);
        }

        return $string;
    }
}
