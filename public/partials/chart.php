<?php
  // If this file is called directly, abort
  if ( ! defined('ABSPATH') ) {
    die;
  }
?>
<div class="cb-chart">
  <div class="cb-remove">&times;</div>
  <input type="hidden" name="quandl_type">
  <div class="cb-field">
    <label for="ticker-type-%%id%%">Source</label>
    <select name="ticker_type" id="ticker-type-%%id%%">
      <option value="yahoo" selected>Yahoo</option>
      <option value="crypto">Cryptocurrency</option>
      <option value="quandl">Quandl</option>
    </select>
  </div>
  <div class="cb-field">
    <label for="ticker-%%id%%">Description</label>
    <input type="text" name="ticker" id="ticker-%%id%%" data-value="">
  </div>
  <div class="cb-column-names">
    <label for="column-names-%%id%%">Column names</label>
    <select name="column_names" id="column-names-%%id%%"></select>
  </div>
  <div class="cb-field">
    <label for="ticker-symbol-%%id%%">Ticker</label>
    <input type="text" name="ticker_symbol" id="ticker-symbol-%%id%%" readonly>
  </div>
  <div class="cb-field">
    <label for="axis-%%id%%">Axis</label>
    <select name="axis" id="axis-%%id%%">
      <option value="left">L</option>
      <option value="right">R</option>
    </select>
  </div>
  <div class="cb-field">
    <label for="chart-type-%%id%%">Chart type</label>
    <select name="chart_type" id="chart-type-%%id%%">
      <option value="line">Line</option>
      <option value="smoothedLine">Smoothed Line</option>
      <option value="column">Bar</option>
      <option value="step">Step</option>
    </select>
  </div>
  <div class="cb-field">
    <label for="line-color-%%id%%">Line color</label>
    <input class="jscolor" type="text" name="line_color" id="line-color-%%id%%" value="000000">
  </div>
  <div class="cb-field">
    <label for="alpha-%%id%%">Fill alpha</label>
    <input type="range" min="0" max="1" step="0.01" value="0" name="alpha" id="alpha-%%id%%">
    <div class="cb-alpha-number">1</div>
  </div>
  <div class="cb-field">
    <label for="line-type-%%id%%">Line type</label>
    <select name="line_type" id="line-type-%%id%%">
      <option value="0">Solid</option>
      <option value="10">Dashed</option>
      <option value="2">Dotted</option>
    </select>
  </div>
</div>