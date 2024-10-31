<?php
register_activation_hook( __FILE__, function() {
	if( current_user_can( 'activate_plugins' ) && !get_option( 'nashrin_installed' ) ){ 
    update_option( 'nashrin_installed', true ); 
    update_option( 'nashrin_snippets_setting', '' ); 
    update_option( 'nashrin_snippet_code', '' ); 
  }

	register_uninstall_hook( __FILE__,function() {
    if ( defined( 'WP_UNINSTALL_PLUGIN' )) { 
      delete_option( 'nashrin_snippets_setting' );
      delete_option( 'nashrin_snippet_code' );
      delete_option( 'nashrin_installed' );
    }
  });
});

?>