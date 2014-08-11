<?php
namespace AMP\User;
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
 
class LoginProvider
{
    private $app;
    
    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }
    
    public function loginUser(Request $request)
    {
        if (is_user_logged_in()) {
            $user = $this->app['user.userProvider']->loadUserByUsername('admin');
            $token = new UsernamePasswordToken($user, null, 'general', $user->getRoles());
            $this->app['security']->setToken($token); //now the user is logged in
        
            //now dispatch the login event
            $event = new InteractiveLoginEvent($request, $token);
            $eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
            $eventDispatcher->dispatch("security.interactive_login", $event);
        }
    }
}
