<?php

// If uninstall not called from WordPress, then exit
if ( ! defined('WP_UNINSTALL_PLUGIN') ) {
  exit;
}

// Connecting the required classes
require_once plugin_dir_path( __FILE__ ) . 'includes/class-chart-builder.php';

// Removing the plugin
$chart_builder = new ChartBuilder\ChartBuilder();
$chart_builder->delete();