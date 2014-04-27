<?php

namespace PradoDigital\Bundle\DicephraseBundle\Diceware;

class RandDice implements DiceInterface
{
    public function roll()
    {
        return mt_rand(1, 6);
    }
}
