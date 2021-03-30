<?php

namespace ChartBuilder;

// If this file is called directly, abort
if ( ! defined('ABSPATH') ) {
  die;
}

if ( ! class_exists('Admin') ) {
  class Admin {
    
    public function __construct() {
      
      add_action( 'admin_menu', [$this, 'addMenuPage'] );
      add_action( 'admin_init', [$this, 'registerSettings'] );
      
    }
    
    // Registering pages in the admin panel
    public function addMenuPage() {
      add_menu_page( 'Chart Builder', 'Chart Builder', 'manage_options', 'cb-settings', [$this, 'showSettingsPage'], 'dashicons-chart-area' );
    }
    
    // Registering settings
    public function registerSettings() {
      
      if ( delete_transient('cb_flush_rules') ) {
        flush_rewrite_rules();
      }
      
      add_settings_section( 'cb_main_section', 'Main settings', '', 'cb-settings' );

      register_setting( 'cb_option_group', 'cb_option', [$this, 'sanitizeOptions'] );

      add_settings_field( 'url', 'Chart builder URL', [$this, 'fillURL'], 'cb-settings', 'cb_main_section' );
      add_settings_field( 'cache_time', 'Historical data cache time', [$this, 'fillCacheTime'], 'cb-settings', 'cb_main_section' );
      add_settings_field( 'quandl_api_key', 'Quandl API key', [$this, 'fillQuandlAPIKey'], 'cb-settings', 'cb_main_section' );

    }
    
    // Showing settings page
    public function showSettingsPage() {
      
      ob_start();
      require_once CB_PATH . 'public/partials/admin/settings-page.php';
      echo ob_get_clean();
      
    }
    
    // Chart builder URL output
    public function fillURL() {
      
      $cb_option = get_option( 'cb_option' );
      $url = $cb_option['url'];
      
      ob_start();
      require_once CB_PATH . 'public/partials/admin/url-field.php';
      $url_field = ob_get_clean();
      
      echo str_replace( '%%url%%', $url, $url_field );
      
    }
    
    // Historical data cache time output
    public function fillCacheTime() {
      
      $cb_option = get_option( 'cb_option' );
      $cache_time = $cb_option['cache_time'];
      
      ob_start();
      require_once CB_PATH . 'public/partials/admin/cache-time-field.php';
      $cache_time_field = ob_get_clean();
      
      echo str_replace( '%%cache_time%%', $cache_time, $cache_time_field );
      
    }
    
    // Quandl API key output
    public function fillQuandlAPIKey() {
      
      $cb_option = get_option( 'cb_option' );
      $quandl_api_key = $cb_option['quandl_api_key'];
      
      ob_start();
      require_once CB_PATH . 'public/partials/admin/quandl-api-key-field.php';
      $quandl_api_key_field = ob_get_clean();
      
      echo str_replace( '%%quandl_api_key%%', $quandl_api_key, $quandl_api_key_field );
      
    }
    
    // Checking the transferred settings
    public function sanitizeOptions( $value ) {
      
      set_transient( 'cb_flush_rules', 1 );
      
      $cb_option = get_option( 'cb_option' );
      
      $url = $value['url'];
      $cache_time = $value['cache_time'];
      $quandl_api_key = $value['quandl_api_key'];
      
      if ( empty($url) || empty($cache_time) || empty($quandl_api_key) ) {
        add_settings_error( 'cb_option', 'cb-option', 'Empty value.' );
        return $cb_option;
      }
      
      return $value;
      
    }
    
  }
}