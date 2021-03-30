<?php

namespace ChartBuilder;
use \stdClass;
use \WP_Post;

// If this file is called directly, abort
if ( ! defined('ABSPATH') ) {
  die;
}

// Loading additional classes
require_once plugin_dir_path( __FILE__ ) . 'class-helper.php';
require_once plugin_dir_path( __FILE__ ) . 'class-admin.php';
require_once plugin_dir_path( __FILE__ ) . 'class-ajax.php';
require_once plugin_dir_path( __FILE__ ) . 'class-api.php';

if ( ! class_exists('ChartBuilder') ) {
  class ChartBuilder {
    
    const PLUGIN_NAME = 'Chart Builder';
    const MIN_PHP_VERSION = '5.5.0';
    
    public function __construct() {
      
      add_action( 'wp_enqueue_scripts', [$this, 'loadStylesScripts'] );
      
      add_filter( 'query_vars', [$this, 'addQueryVar'] );
      add_action( 'init', [$this, 'addRewriteRule'] );
      
      add_filter( 'template_redirect', [$this, 'showChartBuilder'] );
      
      add_filter( 'the_content', ['ChartBuilder\Helper', 'removeAutoP'], 0 );
      
    }
    
    // Runs when the plugin is activated
    public function activate() {
      
      $this->checkPHPVersion();
      $this->checkDirs();
      $this->addOptions();
      
      API::createCurrencyAutocompleteFile();
      
      $this->addRewriteRule();
      flush_rewrite_rules();
      
    }
    
    // Runs when the plugin is uninstalled
    public function delete() {
      
      if ( ! current_user_can('activate_plugins') ) {
        return;
      }
      
      delete_option( 'cb_option' );
      
    }
    
    // Checking the PHP version
    public function checkPHPVersion() {
      if ( version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '<') ) {
        wp_die( sprintf('<p>PHP %s+ is required to use <b>%s</b> plugin. You have %s installed.</p>', self::MIN_PHP_VERSION, self::PLUGIN_NAME, PHP_VERSION), 'Plugin Activation Error', ['response' => 200, 'back_link' => TRUE] );
      }
    }
    
    // Checking if required directories are writable
    public function checkDirs() {
      if ( ! is_writable(CB_PATH . 'data') || ! is_writable(CB_PATH . 'uploads')) {
        wp_die( sprintf('<p>Required directories don\'t writable.</p>'), 'Plugin Activation Error', ['response' => 200, 'back_link' => TRUE] );
      }
    }
    
    // Adding options
    public function addOptions() {
      $options = [ 'url' => 'financial-chart-builder', 'cache_time' => '360', 'quandl_api_key' => '' ];
      add_option( 'cb_option', $options );
    }
    
    // Loading styles and scripts
    public function loadStylesScripts() {
      
      wp_register_style( 'cb-amcharts', CB_URL . 'public/dist/amcharts/style.css' );
      wp_register_style( 'cb-amcharts-export', CB_URL . 'public/dist/amcharts/plugins/export/export.css' );
      wp_register_style( 'cb-rangeslider', CB_URL . 'public/css/rangeslider.css' );
      wp_register_style( 'cb-awesomplete', CB_URL . 'public/css/awesomplete.css' );
      wp_register_style( 'cb-style', CB_URL . 'public/css/style.css' );
      
      wp_register_script( 'cb-amcharts', CB_URL . 'public/dist/amcharts/amcharts.js', [], false, true );
      wp_register_script( 'cb-amcharts-export', CB_URL . 'public/dist/amcharts/plugins/export/export.js', [], false, true );
      wp_register_script( 'cb-serial', CB_URL . 'public/dist/amcharts/serial.js', [], false, true );
      wp_register_script( 'cb-amstock', CB_URL . 'public/dist/amcharts/amstock.js', [], false, true );
      wp_register_script( 'cb-jscolor', CB_URL . 'public/js/jscolor.js', [], false, true );
      wp_register_script( 'cb-rangeslider', CB_URL . 'public/js/rangeslider.min.js', ['jquery'], false, true );
      wp_register_script( 'cb-awesomplete', CB_URL . 'public/js/awesomplete.js', [], false, true );
      wp_register_script( 'cb-main', CB_URL . 'public/js/main.js', ['jquery'], false, true );
      
      wp_enqueue_style( 'cb-amcharts' );
      wp_enqueue_style( 'cb-amcharts-export' );
      wp_enqueue_style( 'cb-rangeslider' );
      wp_enqueue_style( 'cb-awesomplete' );
      wp_enqueue_style( 'cb-style' );
      
      wp_enqueue_script( 'cb-amcharts' );
      wp_enqueue_script( 'cb-amcharts-export' );
      wp_enqueue_script( 'cb-serial' );
      wp_enqueue_script( 'cb-amstock' );
      wp_enqueue_script( 'cb-jscolor' );
      wp_enqueue_script( 'cb-rangeslider' );
      wp_enqueue_script( 'cb-awesomplete' );
      wp_enqueue_script( 'cb-main' );
      
      wp_localize_script( 'cb-main', 'ajaxcb',
        [
          'url' => admin_url('admin-ajax.php'),
          'nonce' => wp_create_nonce('ajaxcb-nonce'),
          'plugin_url' => CB_URL
        ]
      );
      
    }
    
    // Adding query var
    public function addQueryVar( $vars ) {
      $vars[] = 'chart_builder_url';
      return $vars;
    }
    
    // Adding rewrite rule
    public function addRewriteRule() {
      
      $cb_option = get_option( 'cb_option' );
      $url = $cb_option['url'];
      
      add_rewrite_tag( '%chart_builder_url%', '([^&]+)' );
      add_rewrite_rule( $url . '/?$', 'index.php?chart_builder_url=' . $url, 'top' );
      
    }
    
    // Showing chart builder page
    public function showChartBuilder() {
      
      global $wp, $wp_query;
      
      $cb_option = get_option( 'cb_option' );
      $url = $cb_option['url'];
      if ( get_query_var('chart_builder_url') !== $url ) {
        return;
      }
      
      $content = $this->getChartBuilderContent();
      
      $post_id = -999;
      $post = new stdClass();
      $post->ID = $post_id;
      $post->post_author = 1;
      $post->post_date = current_time( 'mysql' );
      $post->post_date_gmt = current_time( 'mysql', 1 );
      $post->post_title = 'Chart Builder';
      $post->post_content = $content;
      $post->comment_status = 'closed';
      $post->ping_status = 'closed';
      $post->post_name = 'chart-builder';
      $post->post_type = 'page';
      $post->filter = 'raw';
      
      $wp_post = new WP_Post( $post );
      wp_cache_add( $post_id, $wp_post, 'posts' );

      $wp_query->post = $wp_post;
      $wp_query->posts = [ $wp_post ];
      $wp_query->queried_object = $wp_post;
      $wp_query->queried_object_id = $post_id;
      $wp_query->found_posts = 1;
      $wp_query->post_count = 1;
      $wp_query->max_num_pages = 1; 
      $wp_query->is_page = true;
      $wp_query->is_singular = true; 
      $wp_query->is_single = false; 
      $wp_query->is_attachment = false;
      $wp_query->is_archive = false; 
      $wp_query->is_category = false;
      $wp_query->is_tag = false; 
      $wp_query->is_tax = false;
      $wp_query->is_author = false;
      $wp_query->is_date = false;
      $wp_query->is_year = false;
      $wp_query->is_month = false;
      $wp_query->is_day = false;
      $wp_query->is_time = false;
      $wp_query->is_search = false;
      $wp_query->is_feed = false;
      $wp_query->is_comment_feed = false;
      $wp_query->is_trackback = false;
      $wp_query->is_home = false;
      $wp_query->is_embed = false;
      $wp_query->is_404 = false;
      $wp_query->is_paged = false;
      $wp_query->is_admin = false; 
      $wp_query->is_preview = false; 
      $wp_query->is_robots = false; 
      $wp_query->is_posts_page = false;
      $wp_query->is_post_type_archive = false;
      
      $GLOBALS['wp_query'] = $wp_query;
      $wp->register_globals();
      
    }
    
    // Getting chart builder content
    public function getChartBuilderContent() {
      
      ob_start();
      require_once CB_PATH . 'public/partials/chart-builder.php';
      $chart_builder = ob_get_clean();
      
      $chart = self::getChartContent();
      $chart_settings = self::getChartSettingsContent();
      
      $chart_builder = str_replace( ['%%chart%%', '%%chart_settings%%'], [$chart, $chart_settings], $chart_builder );
      
      return $chart_builder;
      
    }
    
    // Getting chart content
    public function getChartContent() {
      
      ob_start();
      require_once CB_PATH . 'public/partials/chart.php';
      $chart = ob_get_clean();
      
      $unique_id = uniqid();
      
      $chart = str_replace( '%%id%%', $unique_id, $chart );
      
      return $chart;
      
    }
    
    // Getting chart settings content
    public function getChartSettingsContent() {
      
      ob_start();
      require_once CB_PATH . 'public/partials/chart-settings.php';
      return ob_get_clean();
      
    }
    
  }
}