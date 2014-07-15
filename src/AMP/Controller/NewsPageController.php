<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class NewsPageController implements ControllerProviderInterface
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
            $app['dao.newsContent']->delete($request->get('id'));
        }
        $results = $app['dao.newsContent']->getAll();
        return $app['twig']->render('news.twig', array('results' => $results));
    }

    private function addAction(Request $request, Application $app)
    {
        $form = $app['forms.newsPage'];
        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['dao.newsContent']->add($form->getData());
            return $app->redirect('/news');
        }
        return $app['twig']->render('contentEdit.twig', array('form' => $form->createView(),
                                                              'title' => 'Add',
                                                              'page' => 'News',
                                                              'route' => 'news'));
    }

    private function editAction(Request $request, Application $app, $id)
    {
        $form = $app['forms.newsPage'];
        $form->setData($app['dao.newsContent']->get($id));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['dao.newsContent']->update($id, $form->getData());
            return $app->redirect('/news');
        }
        return $app['twig']->render('contentEdit.twig', array('form' => $form->createView(),
                                                              'title' => 'Edit',
                                                              'page' => 'News',
                                                              'route' => 'news'));
    }
}
