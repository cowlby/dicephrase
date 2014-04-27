<?php

namespace PradoDigital\Bundle\DicephraseBundle\Diceware;

interface WordListInterface extends \ArrayAccess
{
    public function getWord($roll);
}
