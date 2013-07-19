<?php
namespace Cowlby\Dicephrase;

class PassphraseMaker implements PassphraseMakerInterface
{
    protected $wordlist;

    protected $roller;

    public function __construct(WordListInterface $wordlist, DiceRollerInterface $roller)
    {
        $this->wordlist = $wordlist;
        $this->roller = $roller;
    }

    public function generatePassphrase($length)
    {
        $passphrase = array();

    	for ($i = 0; $i < $length; $i++) {
    	    $passphrase[] = $this->wordlist->getWord($this->roller->roll(5));
    	}

    	return $passphrase;
    }
}
