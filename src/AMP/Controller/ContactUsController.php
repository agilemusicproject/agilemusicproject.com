<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ContactUsController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->match('/', function (Request $request) use ($app) {
            return $this->defaultAction($request, $app);
        });

        return $controllers;
    }

    private function defaultAction(Request $request, Application $app)
    {
        $form = $app['forms.contactUs'];
        $viewData = array('form' => $form->createView());
        if ($request->isMethod('POST')) {
            $viewData['emailWasSent'] = false;
            $form->submit($request);
            if ($form->isValid()) {
                $formData = $form->getData();
                $email = $app['amp.email'];
                $email->setRecipient('info@agilemusicproject.com')
                    ->setSubject($formData['subject'])
                    ->setMessage($formData['message'], $formData['name'])
                    ->setSender($formData['email']);
                if ($email->send()) {
                    $viewData['emailWasSent'] = true;
                }
            }
        }
        return $app['twig']->render('contact.twig', $viewData);
    }
}
