<?php

namespace Cowlby\Dicephrase;

class RandomOrgDice implements DiceInterface
{
    protected $rolls;

    public function __construct()
    {
        $this->rolls = array();
    }

    protected function generateRolls()
    {
        $url = 'http://www.random.org/integers/?num=50&min=1&max=6&col=1&base=10&format=plain&rnd=new';
        $context = stream_context_create(array('http' => array(
            'method' => "GET",
            'header' => "User-Agent: Dicephrase/0.x (+https://github.com/cowlby/dicephrase)\r\n"
        )));

        $random = trim(file_get_contents($url, false, $context));

        $this->rolls = explode("\n", $random);
    }

    public function roll()
    {
        if (count($this->rolls) === 0) {
            $this->generateRolls();
        }

        return array_pop($this->rolls);
    }
}
