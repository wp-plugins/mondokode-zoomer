<?php
/*
Plugin Name: MondoKode-Zoomer
Plugin URI: http://todo--createURL
Description: Provides an overlay zoom for code blocks that are too wide for a restricted width column.  Depends on the wp-syntax plugin to function.
Author: Matthieu Cormier
Version: 0.1
Author URI: http://sunflower.coleharbour.ca/cocoamondo
*/

#
#  Copyright (c) MMIX Matthieu Cormier
#
#  This file is part of mondoKode-zoom.
#
#  mondoKode-zoom is free software; you can redistribute it and/or modify it under
#  the terms of the GNU General Public License as published by the Free
#  Software Foundation; either version 2 of the License, or (at your option)
#  any later version.
#
#  mondoKode-zoom is distributed in the hope that it will be useful, but WITHOUT ANY
#  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
#  FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
#  details.
#
#  You should have received a copy of the GNU General Public License along
#  with mondoKode-zoom; if not, write to the Free Software Foundation, Inc., 59
#  Temple Place, Suite 330, Boston, MA 02111-1307 USA
#

// Valid values == yes or no.
$mondoKode_zoom_useFancyButton = 'yes';
$mondoKode_zoom_exposeBGColor = '#999999';

if (!defined("WP_CONTENT_URL")) define("WP_CONTENT_URL", get_option("siteurl") . "/wp-content");
if (!defined("WP_PLUGIN_URL"))  define("WP_PLUGIN_URL",  WP_CONTENT_URL        . "/plugins");

function mondoKode_zoom_head() {
  
  $css_url = mk_base_pluginRef() . "/css/overlay-minimal.css";
  $js_base = mk_base_pluginRef() . "/js";
  
  echo "\n".'<link rel="stylesheet" href="' . $css_url . '" type="text/css" media="screen" />'."\n";

 	mondoKode_addJSFile("jquery-1.3.2.min.js");
  mondoKode_addJSFile("tools.overlay-1.0.4.min.js");  mondoKode_addJSFile("tools.expose-1.0.3.min.js");
  mondoKode_addJSFile("mondoZoom.js");

  global $mondoKode_zoom_counter;
  $mondoKode_zoom_counter = 0;
}

function mondoKode_addJSFile($filename) {
  $js_base = mk_base_pluginRef() . "js/";
  
  echo "<script type=\"text/javascript\" src=\"" 
       . $js_base . $filename . "\"></script>\n";
}

// Include the javascript that creates the overlay blocks.
function mondoKode_zoom_foot() {
  global $mondoKode_zoom_useFancyButton;
  global $mondoKode_zoom_exposeBGColor;
  
  echo "<script>\n\n";
  
  echo "$(function() {\n\n";
  if ( $mondoKode_zoom_useFancyButton == 'yes' ) {
    echo "  $(\"input[rel]\").overlay({\n";
  } else {
    echo "  $(\"button[rel]\").overlay({\n";
  }
  echo "    expose: '" . $mondoKode_zoom_exposeBGColor . "'\n";
  echo"  });\n";  
  echo"});\n";




  
  global $mondoKode_zoom_counter;
  for ($i = 1; $i <= $mondoKode_zoom_counter; $i++) {
      echo "\n mondoKode_zoom_createOverlay(\"overlay" . $i . "\");\n";
  }

  echo "</script>    \n";
    
}

function mk_base_pluginRef() {
  return WP_PLUGIN_URL . "/mondoKode-zoomer/";
}

function mondoKode_zoom_highlight($match) {
  global $mondoKode_zoom_counter;
  $mondoKode_zoom_counter++;
  
  $divID = "overlay" . $mondoKode_zoom_counter;
  
  $convertedmatch = preg_replace("/<div class=\"wp_syntax wp_syntax_zoom\">/i", 
                                 "<div class=\"wp_syntax overlay\" id=\"$divID\">",  
                                 $match[0], 1 
                                 );
  
  
  global $mondoKode_zoom_useFancyButton;
  
  if ( $mondoKode_zoom_useFancyButton == 'yes') {
  $blah = "<div>\n" . 
          "  <input rel=\"#" .  $divID . "\" type=\"image\" class=\"zIndexButtonLink\" " . 	        " src=\"" . mk_base_pluginRef() . "/img/zoom.png\"  >\n" .
          "</div>\n";
    
     $output = $blah . $convertedmatch . "";
  } else {  
    $output = $convertedmatch .
              "<center><button type=\"button\" rel=\"#" . $divID .  
               "\">Zoom Kode</button></center>";
  }   

  
 return $output;
}


function mondoKode_zoom_after_filter($content) {
// Modifiers - http://ca2.php.net/manual/en/reference.pcre.pattern.modifiers.php
//   s -> . matches newlines
//   i -> case insensitive
//   U -> don't be greedy, be ungreedy.
     return preg_replace_callback(
        "/<div class=\"wp_syntax wp_syntax_zoom\">.*<\/pre><\/div><\/div>/siU",
        "mondoKode_zoom_highlight",
        $content
     );
}


 
// Add styling
add_action('wp_head', 'mondoKode_zoom_head');
add_action('wp_footer', 'mondoKode_zoom_foot');


// We want to run when wp_syntax is finished. wp_syntax runs with priority 99.
add_filter('the_content', 'mondoKode_zoom_after_filter', 100);


?>
