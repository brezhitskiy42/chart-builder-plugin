<?php

/**
 * Plugin Name: Chart Builder
 * Description: Allows to display financial charts (stocks, currencies, other economic data) and share them among themselves.
 * Version: 1.0.0
 * Require PHP: 5.5
 */

// If this file is called directly, abort
if ( ! defined('ABSPATH') ) {
  die;
}

// Paths to the main plugin file
define( 'CB_PATH',  plugin_dir_path(__FILE__) );
define( 'CB_URL',  plugin_dir_url(__FILE__) );

// Connecting the main class
require_once plugin_dir_path( __FILE__ ) . 'includes/class-chart-builder.php';

// Activating and deactivating the plugin
function cb_activation() {
  $chart_builder = new ChartBuilder\ChartBuilder();
  $chart_builder->activate();
}

register_activation_hook( __FILE__, 'cb_activation' );

// Running the admin panel functionality
new ChartBuilder\Admin();

// Running the basic functionality
new ChartBuilder\ChartBuilder();