<?php

namespace Cowlby\Dicephrase\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class DicephraseControllerProvider extends AbstractControllerProvider
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->before(function (Request $request) {

            $contentType = current($request->getAcceptableContentTypes());
            $requestFormat = $request->getFormat($contentType);
            $request->setRequestFormat($requestFormat);

        }, Application::EARLY_EVENT);

        $controllers
            ->get('/', array($this, 'getIndexAction'))
            ->bind('home')
        ;

        $controllers
            ->get('/passphrase/{length}', array($this, 'getPassphraseAction'))
            ->bind('passphrase')
            ->assert('length', '\d{1,3}')
            ->value('length', 4)
        ;

        return $controllers;
    }

    public function getIndexAction(Application $app)
    {
        return new RedirectResponse($app['url_generator']->generate('passphrase'));
    }

    public function getPassphraseAction(Application $app, Request $request, $length)
    {
        $passphrase = $app['diceware']->generatePassphrase($length);

        switch ($request->getRequestFormat('html')) {

        	case 'json':
        	    $response = new JsonResponse(array('passphrase' => $passphrase));
        	    break;

        	case 'xml':
        	    $xml = new \SimpleXMLElement('<passphrase/>');
        	    $xml->addAttribute('length', count($passphrase));
        	    foreach ($passphrase as $word) {
        	        $xml->addChild('word', $word);
        	    }
        	    $response = new Response($xml->asXML());
        	    break;

        	default:
        	    $response = new Response(implode(' ', $passphrase));
        	    break;
        }

        return $response;
    }
}
