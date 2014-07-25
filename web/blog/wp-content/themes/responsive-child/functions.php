<?php

add_filter('logout_url', 'my_logout_url');

function my_logout_url($logout_url, $redirect = null) 
{
    return '/admin/logout';
}

add_filter('login_redirect', 'my_redirect_after_login');

function my_redirect_after_login()
{
    return '/';
}
