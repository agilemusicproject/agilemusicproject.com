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
            $id = $request->get('id');
            $photo_data = $dao->get($id);
            $uploadManager = new \AMP\UploadManager(__DIR__ . '/../../../web/images/photos');
            $uploadManager->deleteFile($photo_data['filename']);
            $uploadManager->deleteThumbnail($photo_data['filename']);
            $dao->delete($id);
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
            $uploadManager = new \AMP\UploadManager(__DIR__ . '/../../../web/images/photos');
            $uploadManager->uploadPhoto($formData['photo']);
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
