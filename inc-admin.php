
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'admin_enqueue_scripts', function( $hook ) {
	if ( 'tools_page_content-reset-tool' !== $hook ) {
		return;
	}
	wp_enqueue_style(
		'content-reset-tool-admin',
		plugins_url( 'assets/admin.css', CRT_FILE ),
		array(),
		CRT_VERSION
	);
} );
