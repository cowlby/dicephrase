<?php

namespace PradoDigital\Bundle\DicephraseBundle\Diceware;

interface PassphraseMakerInterface
{
    const DICEWARE_INDEX_LENGTH = 5;
    const DICEWARE_RECOMMENDED_LENGTH = 6;

    public function generatePassphrase($length = self::DICEWARE_RECOMMENDED_LENGTH);
}
