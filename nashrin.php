<?php
/**
 * Plugin Name: نشرین
 * Plugin URI: http://nashrin.com/
 * Description: افزونه نشرین برای وردپرس
 * Version: 1.1
 * Author: Shaya Smart Technologies
 * Author URI: http://ishaya.ir/
 * Text Domain: nashrin
 * Domain Path: /languages/
 */

if ( !defined( 'ABSPATH' ) ) exit;

get_option( 'nashrin_snippet_code' ) OR update_option( 'nashrin_snippet_code', '' );
get_option( 'nashrin_widgets_setting') OR update_option( 'nashrin_widgets_setting', json_encode( array( 'dummy' => array( 'title' => '', 'location' => '', 'snippet' => '', 'nth' => 0, 'cats' => array() ) ) ) );

$added_nashrin_widgets = array();

add_action( 'wp_footer', function () {
  echo '<script src=\'' . get_option( 'nashrin_snippet_code') . '\' type=\'text/javascript\' async></script>';
});

function nashrin_insert_snippet_after_nth_paragraph( $i, $n, $c ) {
  $ps = explode( '</p>', $c );
  array_splice( $ps, $n, 0, $i);
  return implode('', $ps);
}

require( dirname(__FILE__) . '/admin/admin.php' );
require( dirname(__FILE__) . '/widget.php' );
require( dirname(__FILE__) . '/uninstall.php' );

add_action( 'widgets_init' , function() { register_widget('NashrinWidget'); } );
add_action( 'the_content'  , function( $content ) {
  global $added_nashrin_widgets;
  if( is_single() && !is_admin() ) {
    $widgets = (array) json_decode( get_option( 'nashrin_widgets_setting' ) );
    $cats = array();
    foreach( get_the_category() as $cat) {
      $cat = (array) $cat;
      array_push( $cats, $cat['name'] ); 
    }
    foreach ( $widgets as $widget ) {
      $widget = (array) $widget;
      if( array_intersect( $cats, $widget['cats'] ) ) {
        $snippet = '<div id=\'' . $widget['snippet'] . '\'></div>';
        switch ( $widget['location'] ) {
          case 'beginning':
            $content = $snippet . $content;
            array_push( $added_nashrin_widgets, $snippet );
            break;
          case 'end':
            if ( !in_array( $snippet, $added_nashrin_widgets ) ) {
              $content = $content . $snippet;
              array_push( $added_nashrin_widgets, $snippet );
            }
            break;
          case 'inside':
            if ( !in_array( $snippet, $added_nashrin_widgets ) ) {
              $content = nashrin_insert_snippet_after_nth_paragraph( $snippet, $widget['nth'], $content );        
              array_push( $added_nashrin_widgets, $snippet );
            }
            break;
          default: break;
        }
      }
    }
  }
  return $content;
});

add_shortcode( 'nashrin' , function ( $atts, $content ) {
  return $content;
});

?>
