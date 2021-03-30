<?php
  // If this file is called directly, abort
  if ( ! defined('ABSPATH') ) {
    die;
  }
?>
<div class="cb-field">
  <label for="background">Background</label>
  <input class="jscolor" type="text" name="background" id="background" value="ffffff">
</div>
<div class="cb-field">
  <label for="grid-lines-color">Grid lines color</label>
  <input class="jscolor" type="text" name="grid_lines_color" id="grid-lines-color" value="eeeeee">
</div>
<div class="cb-field">
  <label for="grid-lines-color-alpha">Grid lines color alpha</label>
  <input type="range" min="0" max="1" step="0.01" value="1" name="grid_lines_color_alpha" id="grid-lines-color-alpha">
  <div class="cb-alpha-number">1</div>
</div>
<div class="cb-field">
  <label for="line-thickness">Line thickness</label>
  <input type="range" min="1" max="10" step="1" value="1" name="line_thickness" id="line-thickness">
  <div class="cb-alpha-number">1</div>
</div>
<div class="cb-field">
  <label for="background-logo">Background logo</label>
  <input type="file" name="background_logo" id="background-logo">
</div>
<div class="cb-field">
  <label for="background-logo-alpha">Background logo alpha</label>
  <input type="range" min="0" max="1" step="0.01" value="1" name="background_logo_alpha" id="background-logo-alpha">
  <div class="cb-alpha-number">1</div>
</div>
<div class="cb-field cb-checkbox">
  <input type="checkbox" id="display-volume" name="display_volume" checked>
  <label for="display-volume">Display volume chart</label>
</div>