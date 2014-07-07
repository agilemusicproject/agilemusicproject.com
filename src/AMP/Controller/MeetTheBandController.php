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
        $dao = new \AMP\Db\BandMembersDAO($app['db']);
        if ($request->isMethod('POST')) {
            $bandMemberData = $dao->get($request->get('id'));
            $uploadManager = new UploadManager(__DIR__ . '/../../../web/images/photos');
            if (!is_null($bandMemberData['photo_filename'])) {
                $uploadManager->deleteFile($bandMemberData['photo_filename']);
                $uploadManager->deleteThumbnail($bandMemberData['photo_filename']);
            }
            $dao->delete($request->get('id'));
        }
        $results = $dao->getAll();
        return $app['twig']->render('meetTheBand.twig', array('results' => $results));
    }
    
    private function addAction(Request $request, Application $app)
    {
        $formFactory = new \AMP\Form\MeetTheBandFormFactory($app['form.factory']);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $formData = $form->getData();
            $dao = new \AMP\Db\BandMembersDAO($app['db']);
            if (!is_null($formData['photo'])) {
                $uploadManager = new UploadManager(__DIR__ . '/../../../web/images/photos');
                $filename = $uploadManager->uploadPhoto($formData['photo']);
            }
            $dao->add($formData);
            return $app->redirect('/meettheband');
        }
        return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                                  'title' => 'Add'));
    }
    
    private function editAction(Request $request, Application $app, $id)
    {
        $dao = new \AMP\Db\BandMembersDAO($app['db']);
        $formFactory = new \AMP\Form\MeetTheBandFormFactory($app['form.factory'], $dao->get($id), true);
        $form = $formFactory->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $formData = $form->getData();
            $bandMemberData = $dao->get($id);
            $filename = null;
            $uploadManager = new \AMP\UploadManager(__DIR__ . '/../../../web/images/photos');
            if ($formData['photo_actions'] == 'photo_delete') {
                $formData['photo'] = null;
                $uploadManager->deleteFile($bandMemberData['photo_filename']);
            } elseif ($formData['photo_actions'] == 'photo_change') {
                if (!is_null($original_filename)) {
                    $uploadManager->deleteFile($bandMemberData['photo_filename']);
                }
                $filename = $uploadManager->uploadPhoto($formData['photo']);
            } elseif ($formData['photo_actions'] == 'photo_nothing') {
                $data['photo'] = null;
                $filename = $bandMemberData['photo_filename'];
            }
            $dao->update($id, $formData);
            return $app->redirect('/meettheband');
        }
        return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                                  'title' => 'Edit'));
    }
}
