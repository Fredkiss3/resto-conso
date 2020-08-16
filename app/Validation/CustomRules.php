<?php

namespace App\Validation;

class CustomRules
{
    public function validTime(string $str): bool
    {
        $timeBegin = explode(":", $str);

        if(count($timeBegin) == 2) {
            $hours = (int) $timeBegin[0];
            $min = (int) $timeBegin[1];

            return ($hours >= 0 and $hours <= 23) and ($min >=0 and $min <= 59);
        } else {
            return false;
        }
    }

    public function arrayInt($data)
    {
        $valid = true;
        if(is_array($data)) {
           foreach ($data as $key => $val) {
               if(!((int) $val > 0)) {
                   $valid = false;
                   break;
               }
           }
        } else {
            $valid = false;
        }
        return $valid;
    }
}