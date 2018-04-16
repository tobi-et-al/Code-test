<?php
namespace App\Lib;

class TranslateDroidSpeak
{
    /**
     * @param $input
     * @return null|string
     */
    public static function getGalacticBasic($bin)
    {
        $bin = trim($bin);

        if (!empty($bin)) {
            if(!is_null($bin))
            {
                // Convert binary into a string
                $text = array();
                $bin = explode(" ", $bin);
                for($i=0; count($bin)>$i; $i++) {
                    $text[] = chr(bindec($bin[$i]));
                }

                return implode($text);
            }
        }
        return null;
    }
}
