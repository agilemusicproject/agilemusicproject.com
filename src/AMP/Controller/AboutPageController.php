<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

// pull function into class method
class AboutPageController implements ControllerProviderInterface
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
        
        $controllers->match('/edit/{id}', function ($id, Request $request) use ($app) {
            return $this->editAction($request, $app, $id);
        });
        
        return $controllers;
    }
    
    private function defaultAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\AboutContentDAO($app['db']);
        if ($request->isMethod('POST')) {
            $dao->delete($request->get('id'));
        }
        $results = $dao->getAll();
        return $app['twig']->render('about.twig', array('results' => $results));
    }
    
    private function addAction(Request $request, Application $app)
    {
        $formFactory = new \AMP\Form\AboutPageFormFactory($app['form.factory']);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dao = new \AMP\Db\AboutContentDAO($app['db']);
            $dao->add($form->getData());
            return $app->redirect('/about');
        }
        return $app['twig']->render('aboutEdit.twig', array('form' => $form->createView(),
                                                                  'title' => 'Add'));
    }
    
    private function editAction(Request $request, Application $app, $id)
    {
        $dao = new \AMP\Db\AboutContentDAO($app['db']);
        $formFactory = new \AMP\Form\AboutPageFormFactory($app['form.factory'], $dao->get($id), true);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dao->update($id, $form->getData());
            return $app->redirect('/about');
        }
        return $app['twig']->render('aboutEdit.twig', array('form' => $form->createView(),
                                                                  'title' => 'Edit'));
    }
}
