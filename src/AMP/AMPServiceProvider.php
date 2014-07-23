<?php
namespace AMP;

use \Silex\Application;
use \Symfony\Component\HttpFoundation\Request;

class AMPServiceProvider
{
    public function registerDAOs(Application $app)
    {
        $app['dao.aboutContent'] = function () use ($app) {
            return new \AMP\Db\AboutContentDAO($app['db']);
        };
        $app['dao.accountManager'] = function () use ($app) {
            return new \AMP\Db\AccountManagerDAO($app['db']);
        };
        $app['dao.agileContent'] = function () use ($app) {
            return new \AMP\Db\AgileContentDAO($app['db']);
        };
        $app['dao.bandMembers'] = function () use ($app) {
            return new \AMP\Db\BandMembersDAO($app['db']);
        };
        $app['dao.musicContent'] = function () use ($app) {
            return new \AMP\Db\MusicContentDAO($app['db']);
        };
        $app['dao.newsContent'] = function () use ($app) {
            return new \AMP\Db\NewsContentDAO($app['db']);
        };
        $app['dao.photos'] = function () use ($app) {
            return new \AMP\Db\PhotosDAO($app['db']);
        };
    }
    
    public function registerForms(Application $app)
    {
        $app['forms.contactUs'] = function () use ($app) {
            $formFactory = new \AMP\Form\ContactUsFormFactory($app['form.factory']);
            return $formFactory->getForm();
        };
        $app['forms.meetTheBandAdd'] = function () use ($app) {
            $formFactory = new \AMP\Form\MeetTheBandFormFactory($app['form.factory']);
            return $formFactory->getForm();
        };
        $app['forms.meetTheBandEdit'] = function () use ($app) {
            $formFactory = new \AMP\Form\MeetTheBandFormFactory($app['form.factory'], true);
            return $formFactory->getForm();
        };
        $app['forms.musicPage'] = function () use ($app) {
            $formFactory = new \AMP\Form\MusicPageFormFactory($app['form.factory']);
            return $formFactory->getForm();
        };
        $app['forms.newsPage'] = function () use ($app) {
            $formFactory = new \AMP\Form\NewsPageFormFactory($app['form.factory']);
            return $formFactory->getForm();
        };
        $app['forms.photosAdd'] = function () use ($app) {
            $formFactory = new \AMP\Form\PhotosFormFactory($app['form.factory']);
            return $formFactory->getForm();
        };
        $app['forms.photosEdit'] = function () use ($app) {
            $formFactory = new \AMP\Form\PhotosFormFactory($app['form.factory'], true);
            return $formFactory->getForm();
        };
        $app['forms.textArea'] = function () use ($app) {
            $formFactory = new \AMP\Form\TextAreaFormFactory($app['form.factory']);
            return $formFactory->getForm();
        };
        $app['forms.updateAccount'] = function () use ($app) {
            $formFactory = new \AMP\Form\UpdateAccountFormFactory(
                $app['form.factory'],
                $app['dao.accountManager']->getCurrentPassword($app['security']->getToken()->getUsername()),
                $app['security.encoder.digest']
            );
            return $formFactory->getForm();
        };
    }
    
    public function registerUserProviders(Application $app)
    {
        $app['user.userProvider'] = function () use ($app){
            return new \AMP\User\UserProvider($app['db']);
        };
        
        $app['user.loginProvider'] = function () use ($app) {
            return new \AMP\User\LoginProvider($app);
        };
    }
}
