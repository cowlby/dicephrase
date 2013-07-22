<?php

namespace Cowlby\Dicephrase;

use Cowlby\Dicephrase\PassphraseMaker;

class PassphraseMakerTest extends \PHPUnit_Framework_TestCase
{
    private $fixture;

    private $roller;
    private $wordlist;

    protected function setUp()
    {
        parent::setUp();

        $this->wordlist = $this->getMock('Cowlby\Dicephrase\WordListInterface', array('getWord', 'offsetExists', 'offsetGet', 'offsetSet', 'offsetUnset'));
        $this->roller = $this->getMock('Cowlby\Dicephrase\DiceRollerInterface', array('roll'));
        $this->fixture = new PassphraseMaker($this->wordlist, $this->roller);
    }

    protected function tearDown()
    {
        $this->fixture = null;
        $this->wordlist = null;
        $this->roller = null;

        parent::tearDown();
    }

    public function testGeneratePassphraseLengthZero()
    {
        $passphrase = $this->fixture->generatePassphrase(0);
        $this->assertEmpty($passphrase, 'Did not return empty array for zero length passphrase.');
    }

    public function testGeneratePassphraseLengthOne()
    {
        $length = 1;

        $this->roller
            ->expects($this->once())
            ->method('roll')
            ->with(5)
            ->will($this->returnValue('11111'))
        ;

        $this->wordlist->expects($this->once())->method('getWord')->with('11111')->will($this->returnValue('a'));

        $passphrase = $this->fixture->generatePassphrase($length);
        $this->assertEquals(array('a'), $passphrase, 'Did not return expected passphrase.');
    }

    public function testGeneratePassphraseLengthFive()
    {
        $length = 5;

        $this->roller
            ->expects($this->exactly($length))
            ->method('roll')
            ->with(5)
            ->will($this->onConsecutiveCalls('11111', '22222', '33333', '44444', '55555'))
        ;

        $this->wordlist->expects($this->at(0))->method('getWord')->with('11111')->will($this->returnValue('a'));
        $this->wordlist->expects($this->at(1))->method('getWord')->with('22222')->will($this->returnValue('cx'));
        $this->wordlist->expects($this->at(2))->method('getWord')->with('33333')->will($this->returnValue('hq'));
        $this->wordlist->expects($this->at(3))->method('getWord')->with('44444')->will($this->returnValue('orin'));
        $this->wordlist->expects($this->at(4))->method('getWord')->with('55555')->will($this->returnValue('storey'));

        $passphrase = $this->fixture->generatePassphrase($length);
        $this->assertEquals(array('a', 'cx', 'hq', 'orin', 'storey'), $passphrase, 'Did not return expected passphrase.');
    }
}
