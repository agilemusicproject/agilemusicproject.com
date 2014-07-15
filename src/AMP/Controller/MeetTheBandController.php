<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

// pull function into class method
class MeetTheBandController implements ControllerProviderInterface
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

        $controllers->match('/update/{id}', function ($id, Request $request) use ($app) {
            return $this->editAction($request, $app, $id);
        });

        return $controllers;
    }

    private function defaultAction(Request $request, Application $app)
    {
        if ($request->isMethod('POST')) {
            $bandMemberData = $app['dao.bandMembers']->get($request->get('id'));
            if (!is_null($bandMemberData['photo_filename'])) {
                $app['photoUploadManager']->deleteFile($bandMemberData['photo_filename']);
                $app['photoUploadManager']->deleteThumbnail($bandMemberData['photo_filename']);
            }
            $app['dao.bandMembers']->delete($request->get('id'));
        }
        $results = $app['dao.bandMembers']->getAll();
        return $app['twig']->render('meetTheBand.twig', array('results' => $results));
    }

    private function addAction(Request $request, Application $app)
    {
        $form = $app['forms.meetTheBandAdd'];
        $form->handleRequest($request);
        if ($form->isValid()) {
            $formData = $form->getData();
            if (!is_null($formData['photo'])) {
                $formData['photo_filename'] = $app['photoUploadManager']->uploadPhoto($formData['photo']);
            }
            elseif (!is_null($formData['photo_url'])) {
                $formData['photo_filename'] = $app['photoUploadManager']->uploadPhotoFromUrl($formData['photo_url']);
            }
            $app['dao.bandMembers']->add($formData);
            return $app->redirect('/meettheband');
        }
        return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                                  'title' => 'Add'));
    }

    private function editAction(Request $request, Application $app, $id)
    {
        $form = $app['forms.meetTheBandEdit'];
        $form->setData($app['dao.bandMembers']->get($id));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $formData = $form->getData();
            $bandMemberData = $app['dao.bandMembers']->get($id);
            $original_filename = $bandMemberData['photo_filename'];
            $filename = null;
            if ($formData['photo_actions'] == 'photo_delete') {
                $formData['photo'] = null;
                $app['photoUploadManager']->deleteFile($original_filename);
                $app['photoUploadManager']->deleteThumbnail($original_filename);
                $formData['photo_filename'] = null;
            } elseif ($formData['photo_actions'] == 'photo_change') {
                if (!is_null($original_filename)) {
                    $app['photoUploadManager']->deleteFile($original_filename);
                    $app['photoUploadManager']->deleteThumbnail($original_filename);
                }
                $formData['photo_filename'] = $app['photoUploadManager']->uploadPhoto($formData['photo']);
            } elseif ($formData['photo_actions'] == 'photo_nothing') {
                $data['photo'] = null;
                $formData['photo_filename'] = $original_filename;
            } else {
                if (!is_null($original_filename)) {
                    $app['photoUploadManager']->deleteFile($original_filename);
                    $app['photoUploadManager']->deleteThumbnail($original_filename);
                }
                if (!is_null($formData['photo'])) {
                    $formData['photo_filename'] = $app['photoUploadManager']->uploadPhoto($formData['photo']);
                }
                elseif (!is_null($formData['photo_url'])) {
                    $formData['photo_filename'] = $app['photoUploadManager']->uploadPhotoFromUrl($formData['photo_url']);
                }
            }
            $app['dao.bandMembers']->update($id, $formData);
            return $app->redirect('/meettheband');
        }
        return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                                  'title' => 'Edit'));
    }
}
