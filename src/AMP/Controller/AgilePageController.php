<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

// pull function into class method
class AgilePageController implements ControllerProviderInterface
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
            $app['dao.agileContent']->delete($request->get('id'));
        }
        $results = $app['dao.agileContent']->getAll();
        return $app['twig']->render('agile.twig', array('results' => $results));
    }

    private function addAction(Request $request, Application $app)
    {
        $form = $app['forms.textArea'];
        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['dao.agileContent']->add($form->getData());
            return $app->redirect('/agile');
        }
        return $app['twig']->render('contentEdit.twig', array('form' => $form->createView(),
                                                              'title' => 'Add',
                                                              'page' => 'About',
                                                              'route' => 'agile'));
    }

    private function editAction(Request $request, Application $app, $id)
    {
        $form = $app['forms.textArea'];
        $form->setData($app['dao.agileContent']->get($id));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['dao.agileContent']->update($id, $form->getData());
            return $app->redirect('/agile');
        }
        return $app['twig']->render('contentEdit.twig', array('form' =>$form->createView(),
                                                              'title' => 'Edit',
                                                              'page' => 'Agile',
                                                              'route' => 'agile'));
    }
}
