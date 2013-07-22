<?php

namespace Cowlby\Dicephrase;

class RandDice implements DiceInterface
{
    public function roll()
    {
        return mt_rand(1, 6);
    }
}
