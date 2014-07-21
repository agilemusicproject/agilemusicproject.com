<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

// pull function into class method
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
        $notification = null;
        $form = $app['forms.contactUs'];
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $formData = $form->getData();
                $email = $app['amp.email'];
                $email->setRecipient('info@agilemusicproject.com')
                      ->setSubject($formData['subject'])
                      ->setMessage($formData['message'], $formData['name'])
                      ->setSender($formData['email']);
                if ($email->send()) {
                    $notification = true;
                } else {
                    $notification = false;
                }
            } else {
                $notification = false;
            }
        }
        return $app['twig']->render(
            'contact.twig',
            array('form' => $form->createView(),
                  'notification' => $notification)
        );
    }
}
