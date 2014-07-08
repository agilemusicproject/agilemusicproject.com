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
        
        $controllers->match('/edit/{id}', function ($id, Request $request) use ($app) {
            return $this->editAction($request, $app, $id);
        });
        
        return $controllers;
    }
    
    private function defaultAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\PhotosDAO($app['db']);
        if ($request->isMethod('POST')) {
            $photo_data = $dao->get($request->get('id'));
            $app['photoUploadManager']->deleteFile($photo_data['filename']);
            $app['photoUploadManager']->deleteThumbnail($photo_data['filename']);
            $dao->delete($request->get('id'));
        }
        $results = $dao->getAll();
        $categories = $dao->getCategories();
        return $app['twig']->render('photos.twig', array('results' => $results, 'categories' => $categories));
    }
    
    private function addAction(Request $request, Application $app)
    {
        $dao = new \AMP\Db\PhotosDAO($app['db']);
        $formFactory = new \AMP\Form\PhotosFormFactory($app['form.factory']);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $formData = $form->getData();
            $app['photoUploadManager']->uploadPhoto($formData['photo']);
            $dao->add($formData);
            return $app->redirect('/photos');
        }
        return $app['twig']->render('photosEdit.twig', array('form' => $form->createView(),
                                                             'title' => 'Add'));
    }
    
    private function editAction(Request $request, Application $app, $id)
    {
        $dao = new \AMP\Db\PhotosDAO($app['db']);
        $formFactory = new \AMP\Form\PhotosFormFactory($app['form.factory'], $dao->get($id), true);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dao->update($id, $form->getData());
            return $app->redirect('/photos');
        }
        return $app['twig']->render('photosEdit.twig', array('form' => $form->createView(),
                                                             'title' => 'Edit'));
    }
}
