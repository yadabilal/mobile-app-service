<?php

namespace App\Traits;

trait IosVerifyTrait
{
    /**
     * @param $hash
     * @return boolean
     */
    public function iosVerify($hash)
    {
        $lastChar = (int)substr($hash, -1);

        if ($lastChar % 2 == 1) {
            return true;
        }

        return false;
    }
}
