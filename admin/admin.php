<?php

// $_SESSION['csrf_token'] = 'ehsan';

if( is_admin() ) {
  add_action( 'admin_enqueue_scripts', function () {
     wp_enqueue_style ( 'nashrin-font-icon'  ,  plugin_dir_url( __DIR__ ) . 'fonts/nashrin-font.css' );
  });

  add_action( 'admin_menu', function() {
    add_menu_page('تنظیمات ویجت نشرین', 'نشرین', 'manage_options', 'nashrin-settings', 'nashrin_admin_page', 'dashicons-nashrin', 25);
  });
  
}

function nashrin_admin_page() {
  wp_enqueue_style ( 'nashrin-admin-style'  , plugin_dir_url( __DIR__ ) . 'admin/admin.css' );
  wp_enqueue_script( 'nashrin-admin-scripts', plugin_dir_url( __DIR__ ) . 'admin/admin.js', array( 'jquery' ), false, true );
  
  $widgets = (array) json_decode( get_option( 'nashrin_widgets_setting' ) );
  $nonce = ( isset( $_REQUEST['_wpnonce'] ) ? isset( $_REQUEST['_wpnonce'] ) : 'false' );

  if( $_SERVER['REQUEST_METHOD'] == 'POST' && !wp_verify_nonce( $nonce, 'nashrin' ) ) {
    
    // Update Script Code 
    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
      if( $_POST['script_update'] == 'true' ) {
        $src = ( preg_match('/src=(["\'])(.*?)\1/', stripslashes( $_POST['script_code'] ), $match) ? $match[2] : '' );
        $src = htmlentities( $src );
        update_option( 'nashrin_snippet_code', $src );
        die( 'script code updated');
      }
    }
      
    //ِ ِDelete Widget
    if( isset($_POST['widget_delete']) ) {
      if( isset( $widgets[$_POST['id']] ) ) {
        unset($widgets[$_POST['id']]);
        update_option( 'nashrin_widgets_setting', json_encode($widgets) );
      }
      die('delete_done');
    }
    
    // Save Widget
    if ( isset( $_POST['title'] ) && isset( $_POST['snippet'] ) && isset( $_POST['location'] ) && isset( $_POST['nth'] ) ) {
      $snippet = ( preg_match('/id=(["\'])(.*?)\1/', stripslashes( $_POST['snippet'] ), $match) ? $match[2] : '' );
      $cats = (array) $_POST['cats'];
      foreach ($cats as $key => $cat) {
        $cats[$key] = htmlentities( $cat );
      }
      $widgets[$_POST['id']] = array(
        'title'    => htmlentities( $_POST['title'] ),
        'snippet'  => htmlentities( $snippet ),
        'location' => htmlentities( $_POST['location'] ),
        'nth'      => htmlentities( $_POST['nth'] ),
        'cats'     => $cats
      );
      update_option( 'nashrin_widgets_setting', json_encode($widgets) );
      die('save_done');
    }
    
    if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
      die();
    }
  }

  include "widgetConfigForm.php";
}
