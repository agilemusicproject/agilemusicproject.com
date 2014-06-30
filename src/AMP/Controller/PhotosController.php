<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

// pull function into class method
class PhotosController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        $controllers->match('', function (Request $request) use ($app) {
            return $this->defaultAction($request, $app);
        });
        
        $controllers->match('/edit', function (Request $request) use ($app) {
            return $this->editAction($request, $app);
        });
        
        return $controllers;
    }
    
    private function defaultAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\PhotosDAO($app['db']);
        $results = $dao->getAll();
        return $app['twig']->render('photos.twig', array('results' => $results));
    }
    
    private function editAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\PhotosDAO($app['db']);
        $formFactory = new \AMP\Form\PhotosFormFactory($app['form.factory']);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dao->add($form->getData());
            return $app->redirect('/photos');
        }
        return $app['twig']->render('photosEdit.twig', array('form' => $form->createView(),
                                                             'title' => 'Manage'));
    }
}
