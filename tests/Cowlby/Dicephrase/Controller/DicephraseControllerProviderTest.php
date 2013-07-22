<?php

namespace Cowlby\Dicephrase\Controller;

use Silex\WebTestCase;

class DicephraseControllerProviderTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../src/app.php';
        $app['exception_handler']->disable();

        require __DIR__ . '/../../../../resources/config/test.php';
        require __DIR__ . '/../../../../src/controllers.php';

        return $app;
    }

    public function testGetIndexAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isRedirect('/passphrase'));
    }

    public function testGetPassphraseAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/passphrase');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertRegExp('/^[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+$/', $client->getResponse()->getContent());
    }

    public function testGetPassphraseWithLengthAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/passphrase/1');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertRegExp('/^[^\s]+$/', $client->getResponse()->getContent());
    }
}
