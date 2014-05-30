<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\DependencyInjection\Definition;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\FormServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html');
});

$app->get('/blog', function () use ($app) {
    return $app['twig']->render('blog.twig');
});

$app->get('/about', function () use ($app) {
    return $app['twig']->render('about.twig');
});

$app->get('/music', function () use ($app) {
    return $app['twig']->render('music.twig');
});

$app->get('/agile', function () use ($app) {
    return $app['twig']->render('agile.twig');
});

$app->get('/photos', function () use ($app) {
    return $app['twig']->render('photos.twig');
});

$app->get('/meettheband', function () use ($app) {
    return $app['twig']->render('meetTheBand.twig');
});

$app->get('/meettheband/update', function () use ($app) {
    return $app['twig']->render('meetTheBandUpdate.twig');
});

$app->get('/bandMembers', function () use ($app) {
    return $app['twig']->render('bandMembers.twig');
});

$app->match('/contactus', function (Request $request) use ($app) {
    $formDefault = array(
        'name' => 'Your name',
        'email' => 'Your email',
        'message' => 'Your message'
    );
    $form = $app['form.factory']->createBuilder('form', $formDefault, array('csrf_protection' => false))
        ->add('name')
        ->add('email')
        ->add('message', 'textarea', array('label_attr' => array('style' => 'vertical-align: top;'),
                                           'attr' => array('cols' => '20', 'rows' => '10')))
        ->add('submit', 'submit')
        ->getForm();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $form->submit($request);
        if ($form->isValid()) {
            $formDefault = $form->getData();
            return $app->redirect('/contactus');
        } else {
            var_dump($form->getErrorsAsString());
        }
    }
    return $app['twig']->render('contact.twig', array('form' => $form->createView()));
});

$app->run();
