<?php

/*
Plugin Name: WP Sitemap
Plugin URI: https://kevin-benabdelhak.fr/plugins/wp-sitemap/
Description: WP Sitemap est un plugin qui permet d'ajouter un plan de site via un shortcode [sitemap] avec des options pour filtrer par type de contenu et limiter le nombre d'éléments.
Version: 1.0
Author: Kevin Benabdelhak
Author URI: https://kevin-benabdelhak.fr/
Contributors: kevinbenabdelhak
*/



if (!defined('ABSPATH')) {
    exit; 
}



if ( !class_exists( 'YahnisElsts\\PluginUpdateChecker\\v5\\PucFactory' ) ) {
    require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';
}
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$monUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/kevinbenabdelhak/wp-sitemap/', 
    __FILE__,
    'wp-sitemap' 
);
$monUpdateChecker->setBranch('main');





require_once plugin_dir_path(__FILE__) . 'shortcode.php';
require_once plugin_dir_path(__FILE__) . 'page-option.php';
require_once plugin_dir_path(__FILE__) . 'css.php';