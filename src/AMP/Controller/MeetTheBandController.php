<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class MeetTheBandController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        $controllers->match('', function (Request $request) use ($app) {
            $dao = new \AMP\Db\BandMembersDAO($app['db']);
            if ($request->isMethod('POST')) {
                $dao->delete($request->get('id'));
            }
            $results = $dao->getAll();
            return $app['twig']->render('meetTheBand.twig', array('results' => $results));
        });
        
        $controllers->match('/add', function (Request $request) use ($app) {
            $formFactory = new \AMP\Form\MeetTheBandFormFactory($app['form.factory']);
            $form = $formFactory->getForm();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $dao = new \AMP\Db\BandMembersDAO($app['db']);
                $dao->add($form->getData());
                return $app->redirect('/meettheband');
            }
            return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                                      'title' => 'Add'));
        });
        
        $controllers->match('/update/{id}', function ($id, Request $request) use ($app) {
            $dao = new \AMP\Db\BandMembersDAO($app['db']);
            $formFactory = new \AMP\Form\MeetTheBandFormFactory($app['form.factory'], $dao->get($id), true);
            $form = $formFactory->getForm();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $dao->update($id, $form->getData());
                return $app->redirect('/meettheband');
            }
            return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                                      'title' => 'Edit'));
        });
        
        return $controllers;
    }
}
