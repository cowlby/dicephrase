<?php

namespace PradoDigital\Bundle\DicephraseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $diceware = $this->container->get('prado_digital.dicephrase.diceware');

        $passphrase = $diceware->generatePassphrase(5);

        return $this->render(
            'PradoDigitalDicephraseBundle:Default:index.html.twig',
            array(
                'passphrase' => $passphrase
            )
        );
    }
}
