<?php
require_once __DIR__.'/../vendor/autoload.php'; 

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
//use Symfony\Component\Validator\Constraints\NotBlank;
//use Symfony\Component\Validator\Constraints\Type;

$app = new Silex\Application(); 

$app['debug'] = true;

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/admin/',
            'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
            'users' => array(
                'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
            ),
        ),
    )
));

//$app->get('/login', function(Request $request) use ($app) {
//    return $app['twig']->render('login.twig', array(
//        'error'         => $app['security.last_error']($request),
//        'last_username' => $app['session']->get('_security.last_username'),
//    ));
//});

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

//$app->get('/contactus', function () use ($app) {
//    return $app['twig']->render('contact.twig'); 
//});

$app->get('/agile', function () use ($app) {
    return $app['twig']->render('agile.twig'); 
});

$app->get('/photos', function () use ($app) {
    return $app['twig']->render('photos.twig'); 
});

$app->get('/meettheband', function () use ($app) {
    return $app['twig']->render('meetTheBand.twig'); 
});

$app->get('/bandMembers', function () use ($app) {
    return $app['twig']->render('bandMembers.twig'); 
});

$app->post('/contactus', function () use ($app) {

    try {
        $user= 'root';
        $pass = '';

        //connect to database
        $dbh = new PDO('mysql:host=localhost;dbname=amp', $user, $pass);
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        //get the table from the database
        $statement = $dbh->prepare("SELECT * FROM contactband");
        $statement->execute();
        $table = $statement->fetchAll(PDO::FETCH_ASSOC);

        //disconnect from database
        $dbh = null;
    } catch (PDOException $e) {
        print "Error! " . $e->getMessage(). "<br/>";
        die();
    }

    $formDefault = array(
        'first_name' => 'Your first name',
        'last_name' => 'Your last name',
        'email' => 'Your email',
        'instrument' => 'You play??'
    );

    $form = $app['form.factory']->createBuilder('form', $formDefault)
        ->add('first_name')
        ->add('last_name')
        ->add('email')
        ->add('instrument')
        ->add('submit', 'submit')
//        ->add('task', 'text', array(
//        'constraints' => new NotBlank(),
//    ))
        ->getForm();
    
    $request = Request::createFromGlobals();
    
    $form->handleRequest($request);
    
    if ($form->isValid()) {
        $formDefault = $form->getData();

        try {
            $user= 'root';
            $pass = '';
            $dbh = new PDO('mysql:host=localhost;dbname=amp', $user, $pass);
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            $statement = $dbh->prepare("INSERT INTO contactband (firstName, lastName, Email, Instrument) VALUES ".
                                       "(:first, :last, :email, :instrument )");
            
            $statement->bindParam(':first', $formDefault['first_name']);
            $statement->bindParam(':last', $formDefault['last_name']);
            $statement->bindParam(':email', $formDefault['email']);
            $statement->bindParam(':instrument', $formDefault['instrument']);

            $success = $statement->execute();
            
            if( !$success ) {
                print_r($dbh->errorInfo());
                die();
            }
            $dbh = null;
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage(). "<br/>";
            die();
        }

        return $app->redirect('/contactus');
    } else { 
        var_dump($form->getErrorsAsString());
    }

    return $app['twig']->render('contact.twig', array('form' => $form->createView(), 'table' => $table));
});

$app->get('/contactus', function () use ($app) {

    try {
        $user= 'root';
        $pass = '';

        //connect to database
        $dbh = new PDO('mysql:host=localhost;dbname=amp', $user, $pass);
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        $statement = $dbh->prepare("SELECT * FROM contactband");
        $statement->execute();
        $table = $statement->fetchAll(PDO::FETCH_ASSOC);

        //disconnect from database
        $dbh = null;
    } catch (PDOException $e) {
        print "Error! " . $e->getMessage(). "<br/>";
        die();
    }

    $formDefault = array(
        'first_name' => 'Your first name',
        'last_name' => 'Your last name',
        'email' => 'Your email',
        'instrument' => 'You play??'
    );

    $form = $app['form.factory']->createBuilder('form', $formDefault)
        ->add('first_name')
        ->add('last_name')
        ->add('email')
        ->add('instrument')
        ->add('submit', 'submit')
        ->getForm();

    return $app['twig']->render('contact.twig', array('form' => $form->createView(), 'table' => $table));

});

$app->run(); 