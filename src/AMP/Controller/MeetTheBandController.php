<?php
namespace AMP\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use \AMP\Exception\PhotosOptionsException;

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

        $controllers->match('/edit/{id}', function ($id, Request $request) use ($app) {
            return $this->editAction($request, $app, $id);
        });
        $controllers->match('/reorder', function (Request $request) use ($app) {
            return $this->reorderAction($request, $app);
        });

        return $controllers;
    }

    private function defaultAction(Request $request, Application $app)
    {
        if ($request->isMethod('POST')) {
            $bandMemberData = $app['dao.bandMembers']->get($request->get('id'));
            if (!is_null($bandMemberData['photo_filename'])) {
                $app['photoUploadManager']->deleteFileAndThumbnail($bandMemberData['photo_filename']);
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
            switch ($formData['photo_actions']) {
                case 'photo_nothing':
                    $formData['photo'] = null;
                    $formData['photo_filename'] = null;
                    break;
                case 'photo_file':
                    $formData['photo_filename'] = $app['photoUploadManager']->uploadPhoto(
                        $formData['photo'],
                        $formData['photo_rename']
                    );
                    break;
                case 'photo_url':
                    $formData['photo_filename'] = $app['photoUploadManager']->uploadPhotoUrl(
                        $formData['photo_url'],
                        $formData['photo_rename']
                    );
                    break;
                default:
                    throw new PhotosOptionsException();
                    break;
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
            if (!is_null(original_filename) && ($formData['photo_actions'] != "photo_nothing") {
                $app['photoUploadManager']->deleteFileAndThumbnail($original_filename);
            }
            switch ($formData['photo_actions']) {
                case 'photo_delete':
                    $formData['photo'] = null;
                    $formData['photo_filename'] = null;
                    break;
                case 'photo_nothing':
                    $formData['photo_filename'] = $original_filename;
                    break;
                case 'photo_file':
                    $formData['photo_filename'] = $app['photoUploadManager']->uploadPhoto(
                        $formData['photo'],
                        $formData['photo_rename']
                    );
                    break;
                case 'photo_url':
                    $formData['photo_filename'] = $app['photoUploadManager']->uploadPhotoUrl(
                        $formData['photo_url'],
                        $formData['photo_rename']
                    );
                    break;
                default:
                    throw new PhotosOptionsException();
                    break;
            }
            $app['dao.bandMembers']->update($id, $formData);
            return $app->redirect('/meettheband');
        }
        return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                                  'title' => 'Edit'));
    }

    private function reorderAction(Request $request, Application $app)
    {
        if ($request->isMethod('POST')) {
            $app['dao.bandMembers']->reorderUpdate($request->get('list'));
        }
        $results = $app['dao.bandMembers']->getAll();
        return $app['twig']->render('meetTheBand.twig', array('results' => $results));
    }
}
