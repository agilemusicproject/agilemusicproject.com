<?php
namespace AMP\User;
 
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
 
class CustomAuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = get_user_by('login', $request->get('_username'));
        if (!is_wp_error($user)) {
            wp_clear_auth_cookie();
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);
        }
        return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
    }
}
