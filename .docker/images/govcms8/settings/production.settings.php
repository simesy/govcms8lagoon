<?php
/**
 * @file
 * Lagoon Drupal 8 production environment configuration file.
 *
 * This file will only be included on production environments.
 */

// Inject Google Analytics snippet on all production sites.
$config['google_analytics.settings']['codesnippet']['after'] = "gtag('config', 'UA-54970022-1', {'name': 'govcms'}); gtag('govcms.send', 'pageview', {'anonymizeIp': true})";

// Don't show any error messages on the site (will still be shown in watchdog)
$config['system.logging']['error_level'] = 'hide';

// Set max cache lifetime to 1h by default.
$config['system.performance']['cache']['page']['max_age'] = 900;
if (is_numeric($max_age=GETENV('CACHE_MAX_AGE'))) {
  $config['system.performance']['cache']['page']['max_age'] = $max_age;
}

// Aggregate CSS files on.
$config['system.performance']['css']['preprocess'] = 1;

// Aggregate JavaScript files on.
$config['system.performance']['js']['preprocess'] = 1;

// Disabling stage file proxy on production, with that the module can be enabled
// even on production.
$config['stage_file_proxy.settings']['origin'] = false;

// Configure Environment indicator.
$config['environment_indicator.indicator']['bg_color'] = 'red';
$config['environment_indicator.indicator']['name'] = 'Public Domain';

if (!empty($_SERVER['HTTP_HOST'])) {
  $http_host = $_SERVER['HTTP_HOST'];
  if (preg_match('/(?<!www)\.govcms\.gov\.au/i', $http_host)) {
    $config['environment_indicator.indicator']['bg_color'] = 'orange';
    $config['environment_indicator.indicator']['name'] = 'Edit Domain';
  }
}
