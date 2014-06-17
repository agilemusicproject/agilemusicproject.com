<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use AMP\Exception\ConfigValueNotFoundException;
use AMP\Exception\FileNotFoundException;
use AMP\User\UserProvider;
use Silex\Application\UrlGeneratorTrait;
use Silex\Application\SecurityTrait;

$app = new Silex\Application();

try {
    $app['config'] = new AMP\Config(__DIR__ . '/../config/amp.ini');
} catch (FileNotFoundException $e) {
    $app['config'] = new AMP\Config();
}

try {
    $app['debug'] = $app['config']->get('debug');
} catch (ConfigValueNotFoundException $e) {
    $app['debug'] = false;
}

if ($app['debug'] === false) {
    $app->error(function (\Exception $e, $code) use ($app) {
        return new Response($app['twig']->render('base.twig', array('errorMessage' => $e->getMessage())));
    });
}

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => $app['config']->get('MYSQL_HOST'),
        'dbname' => $app['config']->get('MYSQL_DBNAME'),
        'user' => $app['config']->get('MYSQL_USER'),
        'password' => $app['config']->get('MYSQL_PASSWORD'),
    ),
));

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array('translator.messages' => array()));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views', 'twig.options' => array('strict_variables' => false)
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'general' => array(
            'anonymous' => 'true',
            'pattern' => '^/',
            'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
            'logout' => array('logout_path' => '/admin/logout'),
            'users' => $app->share(function () use ($app) {
                // Specific class App\User\UserProvider is described below
                return new UserProvider($app['db']);
            }),
        ),
    ),
    'security.access_rules' => array(
        array('^/meettheband/add', 'ROLE_ADMIN'),
        array('^/admin', 'ROLE_ADMIN'),
        array('^/account', 'ROLE_ADMIN'),
    ),
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

$app->match('/meettheband', function (Request $request) use ($app) {
    $dao = new AMP\Db\BandMembersDAO($app['db']);
    if ($request->isMethod('POST')) {
        $dao->delete($request->get('id'));
    }
    $results = $dao->getAll();
    foreach ($results as &$person) {
        $person['bio'] = explode("\n", $person['bio']);
    }
    unset($person);
    return $app['twig']->render('meetTheBand.twig', array('results' => $results));
});

$app->get('/login', function (Request $request) use ($app) {
    return $app['twig']->render('login.twig', array('error' => $app['security.last_error']($request)));
});

$app->match('/account', function (Request $request) use ($app) {
    $formFactory = new AMP\Form\UpdateAccountFormFactory($app['form.factory']);
    $form = $formFactory->getForm();
    $form->handleRequest($request);
    if ($form->isValid()) {
        $dao = new AMP\Db\AccountManagerDAO($app['db']);
        $data = $form->getData();
        $data['newPassword'] = $app['security.encoder.digest']->encodePassword($data['newPassword'], '');
        $dao->updateBandMemberPassword($data);
        return $app->redirect('/');
    }
    return $app['twig']->render('updateAccount.twig', array('form' => $form->createView()));
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
    return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                              'page' => 'add',
                                                              'title' => 'Add'));
});

$app->match('/meettheband/update/{id}', function ($id, Request $request) use ($app) {
    $dao = new AMP\Db\BandMembersDAO($app['db']);
    $formFactory = new AMP\Form\MeetTheBandFormFactory($app['form.factory'], $dao->get($id));
    $form = $formFactory->getForm();
    $form->handleRequest($request);
    if ($form->isValid()) {
        $dao->update($id, $form->getData());
        return $app->redirect('/meettheband');
    }
    return $app['twig']->render('meetTheBandEdit.twig', array('form' => $form->createView(),
                                                              'page' => 'update',
                                                              'title' => 'Edit'));
});

$app->match('/contactus', function (Request $request) use ($app) {
    $notification = null;
    $formFactory = new AMP\Form\ContactUsFormFactory($app['form.factory']);
    $form = $formFactory->getForm();

    if ($request->isMethod('POST')) {
        $form->submit($request);
        if ($form->isValid()) {
            $formDefault = $form->getData();
            $email = new AMP\Mail();
            $email->setRecipient('info@agilemusicproject.com')
                ->setSubject($formDefault['subject'])
                ->setMessage($formDefault['message'], $formDefault['name'])
                ->setSender($formDefault['email']);
            if ($email->send()) {
                $notification = "Your message was sent successfully.";
            } else {
                $notification = "Your message was not sent. Please try again.";
            }

        } else {
            $formSubmit = "The form is invalid";
        }
    }
    return $app['twig']->render('contact.twig', array('form' => $form->createView(), 'notification' => $notification));
});

$app->run();
