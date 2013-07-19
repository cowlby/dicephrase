<?php
namespace Cowlby\Dicephrase;

class DiceRoller implements DiceRollerInterface
{
    protected $dice;

    public function __construct(DiceInterface $dice)
    {
        $this->dice = $dice;
    }

    public function roll($times)
    {
        $rolled = '';

        for ($i = 0; $i < $times; $i++) {
            $rolled .= $this->dice->roll();
        }

        return $rolled;
    }
}
