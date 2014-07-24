<?php
namespace AMP\User;
 
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Security\Http\Logout\DefaultLogoutSuccessHandler;
 
class CustomLogoutSuccessHandler extends DefaultLogoutSuccessHandler
{

    public function onLogoutSuccess(Request $request)
    {
        wp_logout();
        return $this->httpUtils->createRedirectResponse($request, $this->targetUrl);
    }
}
