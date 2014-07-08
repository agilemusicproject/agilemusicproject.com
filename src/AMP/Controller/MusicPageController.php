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

        return $controllers;
    }

    private function defaultAction(Request $request, Application $app)
    {
        if ($request->isMethod('POST')) {
            $app['dao.musicContent']->delete($request->get('id'));
        }
        $results = $app['dao.musicContent']->getAll();
        return $app['twig']->render('music.twig', array('results' => $results));
    }

    private function addAction(Request $request, Application $app)
    {
        $form = $app['forms.musicPage'];
        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['dao.musicContent']->add($form->getData());
            return $app->redirect('/music');
        }
        return $app['twig']->render('musicEdit.twig', array('form' => $form->createView(),
                                                            'title' => 'Add'));
    }

    private function updateAction(Request $request, Application $app)
    {
        if ($request->isMethod('POST')) {
            $app['dao.musicContent']->sortUpdate($request->get('list'));
        }
        $results = $app['dao.musicContent']->getAll();
        return $app['twig']->render('music.twig', array('results' => $results, 'title' => 'Sort'));
    }
}
