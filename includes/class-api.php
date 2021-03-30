<?php

namespace ChartBuilder;

// If this file is called directly, abort
if ( ! defined('ABSPATH') ) {
  die;
}

if ( ! class_exists('API') ) {
  class API {
    
    // Getting stock autocomplete data
    static public function getStockAutocomplete( $ticker ) {
      
      $ticker = urlencode( $ticker );
      
      $url = "https://finance.yahoo.com/_finance_doubledown/api/resource/searchassist;searchTerm={$ticker}?&intl=us&lang=en-US";
      $stock_resp = wp_remote_get( $url );
      if ( is_wp_error($stock_resp) || wp_remote_retrieve_response_code($stock_resp) !== 200 ) {
        return false;
      }
      
      $stock_data = json_decode( wp_remote_retrieve_body($stock_resp), true );
      
      $items = $stock_data['items'];
      if ( ! $items ) {
        return false;
      }
      
      $list = [];
      foreach ( $items as $item ) {
        $list[] = [ 'label' => $item['name'], 'value' => $item['symbol'], 'source' => 'yahoo' ];
      }
      
      return json_encode( $list );
      
    }
    
    // Getting currency autocomplete data
    static public function getCurrencyAutocomplete() {
      
      $currency_data = self::createCurrencyAutocompleteFile();
      
      if ( $currency_data ) {
        return $currency_data;
      }
      
      return Helper::readCachedFile( 'currency.json' );
      
    }
    
    // Getting Quandl autocomplete data
    static public function getQuandlAutocomplete( $ticker ) {
      
      $ticker = urlencode( $ticker );
      
      $url = "https://www.quandl.com/api/v3/datasets.json?query={$ticker}&database_code=SGE&api_key=" . Helper::getQuandlAPIKey();
      $quandl_resp = wp_remote_get( $url );
      if ( is_wp_error($quandl_resp) || wp_remote_retrieve_response_code($quandl_resp) !== 200 ) {
        return false;
      }
      $quandl_data = json_decode( wp_remote_retrieve_body($quandl_resp), true );
      
      $items = $quandl_data['datasets'];
      if ( ! $items ) {
        return false;
      }
      
      $list = [];
      foreach ( $items as $item ) {
        
        $quandl_status = $item['premium'] ? 'premium' : 'free';
        $quandl_type = ( 'Time Series' === $item['type'] ) ? 'time_series' : 'table';
        
        $list[] = [ 'label' => $item['database_code'], 'value' => $item['name'], 'source' => 'quandl', 'quandl_value' => $item['dataset_code'], 'quandl_status' => $quandl_status, 'quandl_type' => $quandl_type ];
        
      }
      
      return json_encode( $list );
      
    }
    
    // Getting Quandl column names
    static public function getQuandlColumnNames( $codes ) {
      
      $url = "https://www.quandl.com/api/v3/datasets/{$codes}/data.json?api_key=" . Helper::getQuandlAPIKey();
      $quandl_resp = wp_remote_get( $url );
      if ( is_wp_error($quandl_resp) || wp_remote_retrieve_response_code($quandl_resp) !== 200 ) {
        return false;
      }
      $quandl_data = json_decode( wp_remote_retrieve_body($quandl_resp), true );
      
      $column_names = $quandl_data['dataset_data']['column_names'];
      array_shift( $column_names );
      
      if ( count($column_names) === 1 ) {
        return false;
      }
      
      return json_encode( $column_names );
      
    }
    
    // Creating currency autocomplete file
    static public function createCurrencyAutocompleteFile() {
      
      if ( file_exists(CB_PATH . 'data/currency.json') ) { // && ! Helper::isFileCacheExpired('currency.json')
        return false;
      }
      
      $url = 'https://min-api.cryptocompare.com/data/all/coinlist';
      $currency_resp = wp_remote_get( $url );
      if ( is_wp_error($currency_resp) || wp_remote_retrieve_response_code($currency_resp) !== 200 ) {
        return false;
      }
      $currency_data = json_decode( wp_remote_retrieve_body($currency_resp), true );

      $coins = $currency_data['Data'];

      $list = [];
      foreach ( $coins as $coin ) {
        $list[] = [ 'label' => $coin['CoinName'], 'value' => $coin['Symbol'], 'source' => 'crypto' ];
      }

      $fp = fopen( CB_PATH . 'data/currency.json', 'w+' );
      if ( ! $fp ) {
        return false;
      }

      $fwrite_result = fwrite( $fp, json_encode($list) );
      if ( ! $fwrite_result ) {
        return false;
      }

      $fclose_result = fclose( $fp );
      if ( ! $fclose_result ) {
        return false;
      }
      
      return json_encode( $list );
      
    }
    
    // Getting charts data
    static public function getChartsData( $charts ) {
      
      $keys = [ 
        'tickerType',
        'quandlType',
        'ticker',
        'tickerName',
        'column',
        'columnName',
        'axis',
        'chartType',
        'lineColor',
        'alpha',
        'lineType'
      ];
      $charts_data = [];
      foreach ( $charts as $chart ) {
        
        if ( ! Helper::arrayKeysExists($keys,  $chart) ) {
          continue;
        }
        
        $chart_data = null;
        $ticker = $chart['ticker'];
        if ( 'yahoo' === $chart['tickerType'] ) {
          $chart_data = self::getStockData( $chart['ticker'] );
        } elseif ( 'crypto' === $chart['tickerType'] ) {
          $chart_data = self::getCurrencyData( $chart['ticker'] );
        } elseif ( 'quandl' === $chart['tickerType'] ) {
          $chart_data = self::getQuandlData( $chart['ticker'], $chart['quandlType'], $chart['column'] );
          $ticker = str_replace( '/', ' ', $chart['ticker'] );
        }
        
        if ( ! $chart_data ) {
          continue;
        }
        
        $charts_data[] = [
          'data' => $chart_data,
          'tickerType' => $chart['tickerType'],
          'ticker' => $ticker,
          'tickerName' => $chart['tickerName'],
          'columnName' => $chart['columnName'],
          'axis' => $chart['axis'],
          'chartType' => $chart['chartType'],
          'lineColor' => $chart['lineColor'],
          'alpha' => $chart['alpha'],
          'lineType' => $chart['lineType']
        ];
        
      }
      
      return $charts_data;
      
    }
    
    // Getting stock data
    static public function getStockData( $stock ) {
      
      $file_name = 'yahoo_' . strtolower( $stock ) . '.json';
      
      $stock_data = self::createStockFile( $stock, $file_name );
      
      if ( $stock_data ) {
        return $stock_data;
      }
      
      return Helper::readCachedFile( $file_name );
      
    }
    
    // Getting currency data
    static public function getCurrencyData( $currency ) {
      
      $file_name = 'crypto_' . strtolower( $currency ) . '.json';
      
      $currency_data = self::createCurrencyFile( $currency, $file_name );
      
      if ( $currency_data ) {
        return $currency_data;
      }
      
      return Helper::readCachedFile( $file_name );
      
    }
    
    // Getting Quandl data
    static public function getQuandlData( $codes, $quandlType, $column_index ) {
      
      $file_name = 'quandl_' . strtolower( str_replace('/', '_', $codes) ) . '_' . $column_index . '.json';
      
      $quandl_data = self::createQuandlFile( $codes, $quandlType, $column_index, $file_name );
      
      if ( $quandl_data ) {
        return $quandl_data;
      }
      
      return Helper::readCachedFile( $file_name );
      
    }
    
    // Creating stock file
    static public function createStockFile( $stock, $file_name ) {
      
      if ( file_exists(CB_PATH . "data/{$file_name}") && ! Helper::isFileCacheExpired($file_name) ) {
        return false;
      }
      
      $url = "https://query1.finance.yahoo.com/v8/finance/chart/{$stock}?range=5y&interval=1d&includePrePost=false";
      $stock_resp = wp_remote_get( $url );
      if ( is_wp_error($stock_resp) || wp_remote_retrieve_response_code($stock_resp) !== 200 ) {
        return false;
      }
      $stock_data = json_decode( wp_remote_retrieve_body($stock_resp), true );
      
      $stock_result = $stock_data['chart']['result'];
      if ( ! $stock_result ) {
        return false;
      }
      
      $list = [];
      foreach ( $stock_result[0]['timestamp'] as $key => $value ) {
        $list[$key]['date'] = $value;
      }
      foreach ( $stock_result[0]['indicators']['adjclose'][0]['adjclose'] as $key => $value ) {
        $list[$key]['value'] = $value;
      }
      foreach ( $stock_result[0]['indicators']['quote'][0]['volume'] as $key => $value ) {
        $list[$key]['volume'] = $value;
      }
      
      $fp = fopen( CB_PATH . "data/{$file_name}", 'w+' );
      if ( ! $fp ) {
        return false;
      }

      $fwrite_result = fwrite( $fp, json_encode($list) );
      if ( ! $fwrite_result ) {
        return false;
      }

      $fclose_result = fclose( $fp );
      if ( ! $fclose_result ) {
        return false;
      }
      
      return json_encode( $list );
      
    }
    
    // Creating currency file
    static public function createCurrencyFile( $currency, $file_name ) {
      
      if ( file_exists(CB_PATH . "data/{$file_name}") && ! Helper::isFileCacheExpired($file_name) ) {
        return false;
      }
      
      $url = "https://min-api.cryptocompare.com/data/histoday?fsym={$currency}&tsym=USD&limit=2000";
      $currency_resp = wp_remote_get( $url );
      if ( is_wp_error($currency_resp) || wp_remote_retrieve_response_code($currency_resp) !== 200 ) {
        return false;
      }
      $currency_data = json_decode( wp_remote_retrieve_body($currency_resp), true );
      
      $currency_data = $currency_data['Data'];
      if ( ! $currency_data ) {
        return false;
      }
      
      $list = [];
      foreach ( $currency_data as $value ) {
        $list[] = [
          'date' => $value['time'],
          'value' => $value['close'],
          'volume' => $value['volumeto']
        ];
      }
      
      $fp = fopen( CB_PATH . "data/{$file_name}", 'w+' );
      if ( ! $fp ) {
        return false;
      }

      $fwrite_result = fwrite( $fp, json_encode($list) );
      if ( ! $fwrite_result ) {
        return false;
      }

      $fclose_result = fclose( $fp );
      if ( ! $fclose_result ) {
        return false;
      }
      
      return json_encode( $list );
      
    }
    
    // Creating Quandl file
    static public function createQuandlFile( $codes, $quandlType, $column_index, $file_name ) {
      
      if ( file_exists(CB_PATH . "data/{$file_name}") && ! Helper::isFileCacheExpired($file_name) ) {
        return false;
      }
      
      if ( 'time_series' === $quandlType ) {
        $quandl_data = self::getQuandlTimeSeries( $codes, $column_index );
      } else {
        $quandl_data = self::getQuandlTables( $codes, $column_index );
      }
      
      if ( ! $quandl_data ) {
        return false;
      }
      
      $list = [];
      foreach ( $quandl_data as $data ) {
        $list[] = [ 'date' => $data[0], 'value' => $data[1], 'volume' => null ];
      }
      
      $fp = fopen( CB_PATH . "data/{$file_name}", 'w+' );
      if ( ! $fp ) {
        return false;
      }

      $fwrite_result = fwrite( $fp, json_encode($list) );
      if ( ! $fwrite_result ) {
        return false;
      }

      $fclose_result = fclose( $fp );
      if ( ! $fclose_result ) {
        return false;
      }
      
      return json_encode( $list );
      
    }
    
    // Getting Quandl time-series
    static public function getQuandlTimeSeries( $codes, $column_index ) {
      
      $api_key = Helper::getQuandlAPIKey();
        
      $url = "https://www.quandl.com/api/v3/datasets/{$codes}/data.json?api_key={$api_key}&column_index={$column_index}";
      $quandl_resp = wp_remote_get( $url );
      if ( is_wp_error($quandl_resp) || wp_remote_retrieve_response_code($quandl_resp) !== 200 ) {
        return false;
      }
      $quandl_data = json_decode( wp_remote_retrieve_body($quandl_resp), true );
      
      $quandl_data = $quandl_data['dataset_data'];
      $quandl_data = $quandl_data['data'];
      
      if ( ! $quandl_data ) {
        return false;
      }
      
      $quandl_data_with_timestamp = [];
      foreach ( $quandl_data as $data ) {
        $quandl_data_with_timestamp[] = [ strtotime( $data[0] ), $data[1] ];
      }
      $quandl_data = $quandl_data_with_timestamp;
      array_multisort( $quandl_data, SORT_ASC );
      
      $past_timestamp = Helper::getPastTimestamp( 5 );
      $last_data_index = null;
      foreach ( $quandl_data as $data_index => $data ) {
        if ( $data[0] < $past_timestamp ) {
          $last_data_index = $data_index;
          break;
        }
      }
      
      if ( $last_data_index ) {
        array_splice( $quandl_data, $last_data_index );
      }
      
      return $quandl_data;
      
    }
    
    // Getting Quandl tables
    static public function getQuandlTables( $codes, $column_index ) {
      
      $api_key = Helper::getQuandlAPIKey();
        
      $url = "https://www.quandl.com/api/v3/datatables/{$codes}.json?api_key={$api_key}";
      $quandl_resp = wp_remote_get( $url );
      if ( is_wp_error($quandl_resp) || wp_remote_retrieve_response_code($quandl_resp) !== 200 ) {
        return false;
      }
      $quandl_data = json_decode( wp_remote_retrieve_body($quandl_resp), true );
      
      $quandl_data = $quandl_data['datatable'];
      
      $columns = $quandl_data['columns'];
      $column_name = $columns[$column_index]['name'];
      
      $url = "https://www.quandl.com/api/v3/datatables/{$codes}.json?api_key={$api_key}&qopts.columns=date,{$column_name}";
      $quandl_resp = wp_remote_get( $url );
      if ( is_wp_error($quandl_resp) || wp_remote_retrieve_response_code($quandl_resp) !== 200 ) {
        return false;
      }
      $quandl_data = json_decode( wp_remote_retrieve_body($quandl_resp), true );
      
      $quandl_data = $quandl_data['datatable']['data'];
      
      if ( ! $quandl_data ) {
        return false;
      }
      
      $quandl_data_with_timestamp = [];
      foreach ( $quandl_data as $data ) {
        $quandl_data_with_timestamp[] = [ strtotime( $data[0] ), $data[1] ];
      }
      $quandl_data = $quandl_data_with_timestamp;
      array_multisort( $quandl_data, SORT_ASC );
      
      $past_timestamp = Helper::getPastTimestamp( 5 );
      $last_data_index = null;
      foreach ( $quandl_data as $data_index => $data ) {
        if ( $data[0] < $past_timestamp ) {
          $last_data_index = $data_index;
          break;
        }
      }
      
      if ( $last_data_index ) {
        array_splice( $quandl_data, $last_data_index );
      }
      
      return $quandl_data;
      
    }
    
  }
}