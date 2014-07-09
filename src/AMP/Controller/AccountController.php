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
            return $this->defaultAction($request, $app);
        });

        return $controllers;
    }

    public function defaultAction(Request $request, Application $app)
    {
        $notification = null;
        $form = $app['forms.updateAccount'];
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $data['username'] = $app['security']->getToken()->getUsername();
            $data['newPassword'] = $app['security.encoder.digest']->encodePassword($data['newPassword'], '');
            $app['dao.accountManager']->updateBandMemberPassword($data);
            return $app->redirect('/');
        }
        return $app['twig']->render('updateAccount.twig', array(
            'form' => $form->createView(),
            'notification' => $notification,
        ));
    }
    
    public function isValidAuthentication($data)
    {
        if (strcmp($data['oldPassword'], $data['currentPassword'])) {
            return false;
        } else {
            return true;
        }
    }
}
