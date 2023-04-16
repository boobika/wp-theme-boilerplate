<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

define('BOILERPLATE_TEMPLATE_DIR', get_template_directory());
define('BOILERPLATE_TEMPLATE_URI', get_template_directory_uri());

require_once BOILERPLATE_TEMPLATE_DIR . '/inc/PSR4Autoloader.php';
$psr4autoloader = new \Boilerplate\Psr4Autoloader();
$psr4autoloader->addNamespace('Boilerplate', BOILERPLATE_TEMPLATE_DIR . '/inc');
$psr4autoloader->register();

$loader = new \Boilerplate\Loader();
$loader->run();

