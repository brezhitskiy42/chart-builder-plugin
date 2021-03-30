<?php

namespace ChartBuilder;

// If this file is called directly, abort
if ( ! defined('ABSPATH') ) {
  die;
}

if ( ! class_exists('Helper') ) {
  class Helper {
    
    // Removing auto p
    static public function removeAutoP( $content ) {
      
      $cb_option = get_option( 'cb_option' );
      $url = $cb_option['url'];
      if ( get_query_var('chart_builder_url') === $url ) {
        remove_filter( 'the_content', 'wpautop' );
      }
      
      return $content;
      
    }
    
    // Checking if the file cache was expired
    static public function isFileCacheExpired( $file ) {
      
      $last_modified = filemtime( CB_PATH . "data/{$file}" );
      $now = time();
      $cb_option = get_option( 'cb_option' );
      $cache_time = $cb_option['cache_time'] * 60;
      
      return ( ($now - $last_modified) > $cache_time ) ? true : false;
      
    }
    
    // Uploading background logo
    static public function uploadBgLogo( $files ) {
      
      if ( ! $files ) {
        return false;
      }
      
      $img = reset( $files );
      
      $img_type = $img['type'];
      if ( $img_type !== 'image/jpeg' && $img_type !== 'image/png' ) {
        return false;
      }
      
      $img_ext = '.' . pathinfo( $img['name'], PATHINFO_EXTENSION );
      $img_name = uniqid( 'logo-' ) . $img_ext;
      
      $move_result = move_uploaded_file( $img['tmp_name'], CB_PATH . "uploads/{$img_name}" );
      if ( ! $move_result ) {
        return false;
      }
      
      return $img_name;
      
    }
    
    // Checking if multiple array keys exists
    static public function arrayKeysExists( $keys,  $arr ) {
      return ! array_diff_key( array_flip($keys), $arr );
    }
    
    // Getting Quandl API key
    static public function getQuandlAPIKey() {
      
      $cb_option = get_option( 'cb_option' );
      return $cb_option['quandl_api_key'];
      
    }
    
    // Reading cached file
    static public function readCachedFile( $path ) {
      
      if ( file_exists( CB_PATH . "data/{$path}" ) ) {
        return file_get_contents( CB_PATH . "data/{$path}" );
      }
      
      return false;
      
    }
    
    // Getting timestamp by years ago
    static public function getPastTimestamp( $years_ago ) {
      return strtotime( "-{$years_ago} years", time() );
    }
    
  }
}