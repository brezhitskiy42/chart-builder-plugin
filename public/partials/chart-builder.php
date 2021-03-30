<?php
  // If this file is called directly, abort
  if ( ! defined('ABSPATH') ) {
    die;
  }
?>
<div class="cb-chart-builder">
  <div class="cb-chart-series">
    <div class="cb-header">Chart series<button type="button" class="cb-btn" id="cb-reset">Reset</button></div>
    %%chart%%
    <button type="button" class="cb-btn" id="cb-add-more">Add more</button>
  </div>
  <div class="cb-settings">
    <div class="cb-header">General chart settings</div>
    <div class="cb-settings-inner">
      %%chart_settings%%
    </div>
  </div>
  <div class="cb-btn-block">
    <button type="button" class="cb-btn" id="cb-build-chart">Build chart</button>
    <div class="cb-spinner"><div class="cb-double-bounce1"></div><div class="cb-double-bounce2"></div></div>
  </div>
  <div class="cb-fail"></div>
</div>
<div id="cb-amchart"></div>
<div class="cb-chart-sources"></div>