<?php

namespace PradoDigital\Bundle\DicephraseBundle\Diceware;

class OpensslDice implements DiceInterface
{
    public function roll()
    {
        $length = (int) (log(6, 2) / 8) + 1;
        return 1 + (hexdec(bin2hex(openssl_random_pseudo_bytes($length, $s))) % 6);
    }
}
