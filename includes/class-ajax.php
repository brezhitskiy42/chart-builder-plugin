<?php

namespace ChartBuilder;

// If this file is called directly, abort
if ( ! defined('ABSPATH') ) {
  die;
}

if ( ! class_exists('AJAX') ) {
  
  class AJAX {
    
    public function __construct() {
      if( defined('DOING_AJAX') ){
        
        add_action( 'wp_ajax_add_more_chart', [$this, 'addChart'] );
        add_action( 'wp_ajax_nopriv_add_more_chart', [$this, 'addChart'] );
        
        add_action( 'wp_ajax_load_autocomplete_data', [$this, 'loadAutocompleteData'] );
        add_action( 'wp_ajax_nopriv_load_autocomplete_data', [$this, 'loadAutocompleteData'] );
        
        add_action( 'wp_ajax_load_quandl_column_names', [$this, 'loadQuandlColumnNames'] );
        add_action( 'wp_ajax_nopriv_load_quandl_column_names', [$this, 'loadQuandlColumnNames'] );
        
        add_action( 'wp_ajax_build_chart', [$this, 'buildChart'] );
        add_action( 'wp_ajax_nopriv_build_chart', [$this, 'buildChart'] );
        
      }
    }
    
    // Adding new chart
    public function addChart() {
      
      check_ajax_referer( 'ajaxcb-nonce', 'nonce_code' );
      
      echo ChartBuilder::getChartContent();
      wp_die();
      
    }
    
    // Loading autocomplete data
    public function loadAutocompleteData() {
      
      check_ajax_referer( 'ajaxcb-nonce', 'nonce_code' );
      
      if ( ! isset($_POST['ticker']) || empty($_POST['ticker']) || ! isset($_POST['tickerType']) || empty($_POST['tickerType']) ) {
        wp_die( -1 );
      }
      
      $ticker = trim( sanitize_text_field($_POST['ticker']) );
      $ticker_type = trim( sanitize_text_field($_POST['tickerType']) );
      
      $autocomplete_data = [];
      if ( 'yahoo' === $ticker_type ) {
        $autocomplete_data = API::getStockAutocomplete( $ticker );
      } elseif ( 'crypto' === $ticker_type ) {
        $autocomplete_data = API::getCurrencyAutocomplete();
      } elseif ( 'quandl' === $ticker_type ) {
        $autocomplete_data = API::getQuandlAutocomplete( $ticker );
      }
      
      if ( ! $autocomplete_data ) {
        wp_die( -1 );
      }
      
      echo $autocomplete_data;
      wp_die();
      
    }
    
    // Loading Quandl column names
    public function loadQuandlColumnNames() {
      
      check_ajax_referer( 'ajaxcb-nonce', 'nonce_code' );
      
      if ( ! isset($_POST['codes']) || empty($_POST['codes']) ) {
        wp_die( -1 );
      }
      
      $codes = trim( sanitize_text_field($_POST['codes']) );
      
      $column_names = API::getQuandlColumnNames( $codes );
      if ( ! $column_names ) {
        wp_die( -1 );
      }
      
      echo $column_names;
      wp_die();
      
    }
    
    // Building chart
    public function buildChart() {
      
      check_ajax_referer( 'ajaxcb-nonce', 'nonce_code' );
      
      if ( ! isset($_POST['charts']) || empty($_POST['charts']) || ! isset($_POST['settings']) || empty($_POST['settings']) ) {
        wp_send_json_error( 'Error.' );
      }
      
      $bg_logo = Helper::uploadBgLogo( $_FILES );
      
      $_POST['charts'] = str_replace( '\\', '', $_POST['charts'] );
      $_POST['settings'] = str_replace( '\\', '', $_POST['settings'] );
      
      $charts = json_decode( $_POST['charts'], true );
      $settings = json_decode( $_POST['settings'], true );
      
      $charts_data = API::getChartsData( $charts );
      $settings_keys = [ 'background', 'gridLinesColor', 'gridLinesColorAlpha', 'lineThickness', 'backgroundLogoAlpha', 'displayVolume' ];
      if ( ! $charts_data || ! Helper::arrayKeysExists($settings_keys,  $settings) ) {
        wp_send_json_error( 'Error.' );
      }
      
      $data = [
        'charts_data' => $charts_data,
        'settings' => $settings
      ];
      if ( $bg_logo ) {
        $data['settings']['bgLogo'] = $bg_logo;
      }
      
      wp_send_json_success( $data );
      
    }
    
  }
  
  new AJAX();
  
}