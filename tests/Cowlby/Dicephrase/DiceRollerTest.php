<?php

namespace Cowlby\Dicephrase;

use Cowlby\Dicephrase\DiceRoller;

class DiceRollerTest extends \PHPUnit_Framework_TestCase
{
    private $fixture;

    private $dice;

    protected function setUp()
    {
        parent::setUp();

        $this->dice = $this->getMock('Cowlby\Dicephrase\DiceInterface', array('roll'));
        $this->fixture = new DiceRoller($this->dice);
    }

    protected function tearDown()
    {
        $this->fixture = null;

        parent::tearDown();
    }

    public function testRollZero()
    {
        $this->dice
            ->expects($this->never())
            ->method('roll')
        ;

        $roll = $this->fixture->roll(0);
        $this->assertEquals('', $roll, 'Did not return expected roll.');
    }

    public function testRollOne()
    {
        $this->dice
            ->expects($this->once())
            ->method('roll')
            ->will($this->returnValue(1))
        ;

        $roll = $this->fixture->roll(1);
        $this->assertEquals('1', $roll, 'Did not return expected roll.');
    }

    public function testRollFive()
    {
        $this->dice
            ->expects($this->exactly(5))
            ->method('roll')
            ->will($this->onConsecutiveCalls(1, 2, 3, 4, 5))
        ;

        $roll = $this->fixture->roll(5);
        $this->assertEquals('12345', $roll, 'Did not return expected roll.');
    }
}
