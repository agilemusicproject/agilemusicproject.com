<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class MusicPageController implements ControllerProviderInterface
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

        $controllers->match('/update', function (Request $request) use ($app) {
            return $this->updateAction($request, $app);
        });

        $controllers->match('/edit/{id}', function ($id, Request $request) use ($app) {
            return $this->editAction($request, $app, $id);
        });

        return $controllers;
    }

    private function defaultAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\MusicContentDAO($app['db']);
        if ($request->isMethod('POST')) {
            $dao->delete($request->get('id'));
        }
        $results = $dao->getAll();
        return $app['twig']->render('music.twig', array('results' => $results));
    }

    private function addAction(Request $request, Application $app)
    {
        $formFactory = new \AMP\Form\MusicPageFormFactory($app['form.factory']);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dao = new \AMP\Db\MusicContentDAO($app['db']);
            $dao->add($form->getData());
            return $app->redirect('/music');
        }
        return $app['twig']->render('musicEdit.twig', array('form' => $form->createView(),
                                                            'title' => 'Add'));
    }

    private function editAction(Request $request, Application $app, $id)
    {
        $dao = new \AMP\Db\MusicContentDAO($app['db']);
        $formFactory = new \AMP\Form\MusicPageFormFactory($app['form.factory'], $dao->get($id), true);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dao->update($id, $form->getData());
            return $app->redirect('/music');
        }
        return $app['twig']->render('musicEdit.twig', array('form' => $form->createView(),
                                                            'title' => 'Edit'));
    }

    private function updateAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\MusicContentDAO($app['db']);
        var_dump($request->getMethod());
        if ($request->isMethod('POST')) {
            $dao->sortUpdate($request->get('list'));
        }
        $results = $dao->getAll();
        return $app['twig']->render('musicUpdate.twig', array('results' => $results, 'title' => 'Sort'));
    }
}
