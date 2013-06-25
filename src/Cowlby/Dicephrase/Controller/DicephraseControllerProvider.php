<?php

namespace Cowlby\Dicephrase\Controller;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Yaml\Yaml;

class DicephraseControllerProvider extends AbstractControllerProvider
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers
            ->get('/', array($this, 'generatePassphraseAction'))
            ->bind('home')
        ;

        $controllers
            ->post('/', array($this, 'generatePassphraseAction'))
            ->bind('generate')
        ;

        $controllers
            ->get('/passphrase/{length}', array($this, 'getPassphraseAction'))
            ->bind('passphrase')
        ;

        return $controllers;
    }

    public function getPassphraseAction(Application $app, $length)
    {
        $diceware = array();

        for ($i = 0; $i < $length; $i ++) {

            for ($j = 0; $j < 5; $j++) {
                $diceware['words'][$i]['rolls'][$j] = mt_rand(1, 6);
            }

            $diceware['words'][$i]['result'] = implode('', $diceware['words'][$i]['rolls']);
            $diceware['words'][$i]['word'] = $app['diceware'][$diceware['words'][$i]['result']];
        }

        $diceware['passphrase'] = trim(array_reduce($diceware['words'], function($phrase, $word) {
            return $phrase . ' ' . $word['word'];
        }, ''));

        return new Response($app['twig']->render('passphrase.html.twig', array(
            'diceware' => $diceware
        )));
    }

    public function generatePassphraseAction(Application $app, Request $request)
    {
        $passphrase = null;
        $choices = array_keys($app['diceware']);

        $validators = array();
        for ($i = 0; $i < 8; $i++) {
            $validators[] = new Assert\Choice($choices);
        }

        $form = $app['form.factory']->createBuilder('form', array('rolls' => array('', '')))
            ->setAction($app['url_generator']->generate('generate'))
            ->setMethod('POST')
            ->add('rolls', 'collection', array(
                'type' => 'text',
                'error_bubbling' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array('attr' => array('class' => 'input-small')),
                'constraints' => new Assert\Collection(array(
                    'fields' => $validators,
                    'allowExtraFields' => true,
                    'allowMissingFields' => true
                ))
            ))
            ->add('generate', 'submit')
            ->getForm();

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            $words = array();
            if ($form->isValid()) {
                $data = $form->getData();
                foreach ($data['rolls'] as $id => $result) {
                    $words[] = $app['diceware'][$result];
                }
            }

            $passphrase = implode(' ', $words);
        }

        return new Response($app['twig']->render('index.html.twig', array(
            'form' => $form->createView(),
            'passphrase' => $passphrase
        )));
    }
}
