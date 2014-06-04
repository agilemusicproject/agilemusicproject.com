<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\DependencyInjection\Definition;

$app = new Silex\Application();

$app['debug'] = true;

$app['debug'] = true;
$app['upload_folder'] = __DIR__ . '/images/photos';
$app['config'] = new AMP\Config(__DIR__ . '/../config/amp.ini');

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
    try {
        $dsn = 'mysql:host=' . $app['config']->get('host', 'MySQL') .
            '; dbname=' . $app['config']->get('database', 'MySQL');
        $dbh = new PDO($dsn, $app['config']->get('username', 'MySQL'), $app['config']->get('password', 'MySQL'));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM band_members";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    $dbh = null;
    return $app['twig']->render('meetTheBand.twig', array('results' => $results));
});

$app->match('/meettheband/add', function (Request $request) use ($app) {
    $form = $app['form.factory']->createBuilder('form', array('csrf_protection' => false))
        ->add('first_name', 'text', array('required' => true, 'label' => false,
                                          'attr' => array('placeholder' => 'First Name')))
        ->add('last_name', 'text', array('required' => true, 'label' => false,
                                         'attr' => array('placeholder' => 'Last Name')))
        ->add('roles', 'text', array('required' => true, 'label' => false,
                                     'attr' => array('placeholder' => 'Roles')))
        ->add('photo', 'file', array('required' => false))
        ->add('bio', 'textarea', array('label' => false, 'label_attr' => array('style' => 'vertical-align: top;'),
                                       'attr' => array('placeholder' => 'Bio',
                                                       'cols' => '100', 'rows' => '20'), 'required' => false))
        ->add('submit', 'submit')
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();
        $filename = null;
        if (!is_null($data['photo']))
        {
            $image = $data['photo'];
            $filename =  $image->getClientOriginalName();
            $image->move($app['upload_folder'], $filename);
        }
        try {
            $dsn = 'mysql:host=' . $app['config']->get('host', 'MySQL') .
                '; dbname=' . $app['config']->get('database', 'MySQL');
            $dbh = new PDO($dsn, $app['config']->get('username', 'MySQL'), $app['config']->get('password', 'MySQL'));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO band_members (first_name, last_name, roles, photo_filename, bio)
                    VALUES (:first_name, :last_name, :roles, :filename, :bio)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':roles', $data['roles']);
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':bio', $data['bio']);
            $stmt->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $dbh = null;
        var_dump($data);
        return 'hello';
    }
    return $app['twig']->render('meetTheBandAdd.twig', array('form' => $form->createView()));
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

var_dump(getenv("TESTVAR"));

$app->run();
