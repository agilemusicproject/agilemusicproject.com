<?php
/**
 * This is in place of .htaccess for the built-in PHP server.
 * Mostly, this is needed for Codeship CI.
 */
if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    return false; // serve the requested resource as-is.
} else {
    include_once 'index.php';
}
