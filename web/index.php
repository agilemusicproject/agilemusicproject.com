<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Validator\Constraints as Assert;

$app = new Silex\Application();
$app['debug'] = true;
$app['config'] = new AMP\Config(__DIR__ . '/../config/amp.ini');
$dsn = 'mysql:host=' . $app['config']->get('host', 'MySQL') . '; dbname=' . $app['config']->get('database', 'MySQL');
$app['db'] = new PDO($dsn, $app['config']->get('username', 'MySQL'), $app['config']->get('password', 'MySQL'));
//$dsn = 'mysql:host=localhost; dbname=amp';
//$app['db'] = new PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
$app['db']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
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
    $dao = new AMP\Db\BandMembersDAO($app['db']);
    $results = $dao->getAll();
    return $app['twig']->render('meetTheBand.twig', array('results' => $results));
});

$app->match('/meettheband/add', function (Request $request) use ($app) {
    $formFactory = new AMP\Form\MeetTheBandFormFactory($app['form.factory']);
    $form = $formFactory->getForm();
    $form->handleRequest($request);
    if ($form->isValid()) {
        $dao = new AMP\Db\BandMembersDAO($app['db']);
        $dao->add($form->getData());
        return $app->redirect('/meettheband');
    }
    return $app['twig']->render('meetTheBandAdd.twig', array('form' => $form->createView()));
});

$app->match('/meettheband/update/{id}', function($id, Request $request) use ($app) {
    $formFactory = new AMP\Form\MeetTheBandFormFactory($app['form.factory']);
    $form = $formFactory->getForm();
    $form->handleRequest($request);
    if ($form->isValid()) {
        $dao = new AMP\Db\BandMembersDAO($app['db']);
        $dao->update($id, $form->getData());
        return $app->redirect('/meettheband');
    }
    return $app['twig']->render('meetTheBandAdd.twig', array('form' => $form->createView()));
});

$app->match('/contactus', function (Request $request) use ($app) {
    $formSubmit = null;
    $form = $app['form.factory']->createBuilder('form', array('csrf_protection' => false))
        ->add('name', 'text', array(
            'constraints' => new Assert\NotBlank(),
            'attr' => array('placeholder' => "Your name"),
        ))
        ->add('email', 'text', array(
            'constraints' => new Assert\Email(),
            'attr' => array('placeholder' => "Your email"),
        ))
        ->add('subject', 'text', array(
            'attr' => array('placeholder' => "Hot topic"),
            'required' => false,
        ))
        ->add('message', 'textarea', array(
            'label_attr' => array('style' => 'vertical-align: top;'),
            'attr' => array('cols' => '30', 'rows' => '10', 'placeholder' => 'What would you like to say?'),
            'constraints' => new Assert\NotBlank(),
        ))
        ->add('submit', 'submit')
        ->getForm();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $form->submit($request);
        if ($form->isValid()) {
            $formDefault = $form->getData();
            $formatMessage = 'From: ' . $formDefault['name'] . PHP_EOL . PHP_EOL;
            $formatMessage .= $formDefault['message'] . PHP_EOL;
            $message = \Swift_Message::newInstance()
                ->setSubject($formDefault['subject'])
                ->setFrom(array($formDefault['email']))
                ->setTo(array('info@agilemusicproject.com'))
                ->setBody($formatMessage);

            $results = $app['mailer']->send($message);
            $formSubmit = "Your message was sent successfully";
        } else {
            //var_dump($form->getErrorsAsString());
            $formSubmit = "The form is invalid";
        }
    }
    return $app['twig']->render('contact.twig', array('form' => $form->createView(), 'formSubmit' => $formSubmit));
});

var_dump(getenv("TESTVAR"));

$app->run();
