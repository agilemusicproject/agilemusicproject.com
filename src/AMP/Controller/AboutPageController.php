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
        if ($request->isMethod('POST')) {
            $app['dao.aboutContent']->delete($request->get('id'));
        }
        $results = $app['dao.aboutContent']->getAll();
        return $app['twig']->render('about.twig', array('results' => $results));
    }
    
    private function addAction(Request $request, Application $app)
    {
        $form = $app['forms.textArea'];
        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['dao.aboutContent']->add($form->getData());
            return $app->redirect('/about');
        }
        return $app['twig']->render('contentEdit.twig', array('form' => $form->createView(),
                                                              'title' => 'Add',
                                                              'page' => 'About',
                                                              'elementTitle' => 'about'));
    }
    
    private function editAction(Request $request, Application $app, $id)
    {
        $form = $app['forms.textArea'];
        $form->setData($app['dao.aboutContent']->get($id));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['dao.aboutContent']->update($id, $form->getData());
            return $app->redirect('/about');
        }
        return $app['twig']->render('contentEdit.twig', array('form' => $form->createView(),
                                                              'title' => 'Edit',
                                                              'page' => 'About',
                                                              'elementTitle' => 'about'));
    }
}
