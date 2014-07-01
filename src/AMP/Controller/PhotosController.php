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
        
        $controllers->match('/add', function (Request $request) use ($app) {
            return $this->addAction($request, $app);
        });
        
        return $controllers;
    }
    
    private function defaultAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\PhotosDAO($app['db']);
        if ($request->isMethod('POST')) {
            $dao->delete($request->get('id'));
        }
        $results = $dao->getAll();
        return $app['twig']->render('photos.twig', array('results' => $results));
    }
    
    private function addAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\PhotosDAO($app['db']);
        $results = $dao->getAll();
        $formFactory = new \AMP\Form\PhotosFormFactory($app['form.factory']);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dao->add($form->getData());
            return $app->redirect('/photos');
        }
        return $app['twig']->render('photosEdit.twig', array('form' => $form->createView(),
                                                             'title' => 'Add'));
    }
}
