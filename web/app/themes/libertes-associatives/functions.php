<?php

/**
 * Thème Libertés associatives.
 *
 * Timber est chargé par l'autoloader Composer de Bedrock (vendor/autoload.php).
 */

use Timber\Timber;

Timber::init();

Timber::$dirname = ['templates'];

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
});
