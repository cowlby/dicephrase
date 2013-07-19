<?php

namespace Cowlby\Dicephrase;

interface WordListInterface extends \ArrayAccess
{
    public function getWord($roll);
}
