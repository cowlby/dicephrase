<?php
namespace Cowlby\Dicephrase;

interface PassphraseMakerInterface
{
    public function generatePassphrase($length);
}
