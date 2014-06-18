<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class AccountController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        $controllers->match('', function (Request $request) use ($app) {
            $formFactory = new \AMP\Form\UpdateAccountFormFactory($app['form.factory']);
            $form = $formFactory->getForm();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $dao = new \AMP\Db\AccountManagerDAO($app['db']);
                $data = $form->getData();
                $data['newPassword'] = $app['security.encoder.digest']->encodePassword($data['newPassword'], '');
                $dao->updateBandMemberPassword($data);
                return $app->redirect('/');
            }
            return $app['twig']->render('updateAccount.twig', array('form' => $form->createView()));
        });

        return $controllers;
    }
}