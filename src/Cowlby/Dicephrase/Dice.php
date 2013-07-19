<?php

namespace Cowlby\Dicephrase;

class Dice implements DiceInterface
{
    public function roll()
    {
        return mt_rand(1, 6);
    }
}
