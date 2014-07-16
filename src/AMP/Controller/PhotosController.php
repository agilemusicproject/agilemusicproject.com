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
        if ($request->isMethod('POST')) {
            $photo_data = $app['dao.photos']->get($request->get('id'));
            $app['photoUploadManager']->deleteFile($photo_data['filename']);
            $app['photoUploadManager']->deleteThumbnail($photo_data['filename']);
            $app['dao.photos']->delete($request->get('id'));
        }
        $results = $app['dao.photos']->getAll();
        $categories = $app['dao.photos']->getCategories();
        return $app['twig']->render('photos.twig', array('results' => $results, 'categories' => $categories));
    }

    private function addAction(Request $request, Application $app)
    {
        $form = $app['forms.photosAdd'];
        $form->handleRequest($request);
        if ($form->isValid()) {
            $formData = $form->getData();
            if (!is_null($formData['photo'])) {
                $formData['filename'] = $app['photoUploadManager']->uploadPhoto($formData['photo']);
            } elseif (!is_null($formData['photo_url'])) {
                $formData['filename'] = $app['photoUploadManager']->uploadPhotoUrl($formData['photo_url']);
            }
            $app['dao.photos']->add($formData);
            return $app->redirect('/photos');
        }
        return $app['twig']->render('photosEdit.twig', array('form' => $form->createView(),
                                                             'title' => 'Add'));
    }

    private function editAction(Request $request, Application $app, $id)
    {
        $form = $app['forms.photosEdit'];
        $form->setData($app['dao.photos']->get($id));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['dao.photos']->update($id, $form->getData());
            return $app->redirect('/photos');
        }
        return $app['twig']->render('photosEdit.twig', array('form' => $form->createView(),
                                                             'title' => 'Edit'));
    }
}
