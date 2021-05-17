<?php

namespace App\Traits;

trait GoogleVerifyTrait
{
    /**
     * @param $hash
     * @return boolean
     */
    public function googleVerify($hash)
    {
        $lastChar = (int)substr($hash, -1);

        if ($lastChar % 2 == 0) {
            return true;
        }

        return false;
    }
}
