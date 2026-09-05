<?php
/**
 * Plugin Name: Content Reset Tool
 * Plugin URI: https://grazingminds.co.in/
 * Description: Safely remove WordPress content and optionally media so a development or staging site can start clean.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Grazing Minds
 * Author URI: https://grazingminds.co.in/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: content-reset-tool
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CRT_VERSION', '1.0.0' );
define( 'CRT_FILE', __FILE__ );
define( 'CRT_DIR', plugin_dir_path( __FILE__ ) );

require_once CRT_DIR . 'inc-admin.php';

add_action( 'admin_menu', 'crt_register_admin_page' );

function crt_register_admin_page() {
	add_management_page(
		__( 'Content Reset', 'content-reset-tool' ),
		__( 'Content Reset', 'content-reset-tool' ),
		'manage_options',
		'content-reset-tool',
		'crt_render_admin_page'
	);
}

function crt_get_counts() {
	global $wpdb;

	$counts = array(
		'posts'    => 0,
		'pages'    => 0,
		'custom'   => 0,
		'media'    => 0,
		'comments' => 0,
		'terms'    => 0,
		'menus'    => 0,
	);

	$rows = $wpdb->get_results(
		"SELECT post_type, COUNT(*) AS total FROM {$wpdb->posts} GROUP BY post_type",
		ARRAY_A
	);

	$core_types = array( 'post', 'page', 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache', 'wp_template', 'wp_template_part', 'wp_global_styles' );

	foreach ( $rows as $row ) {
		$type  = (string) $row['post_type'];
		$total = (int) $row['total'];

		if ( 'post' === $type ) {
			$counts['posts'] += $total;
		} elseif ( 'page' === $type ) {
			$counts['pages'] += $total;
		} elseif ( 'attachment' === $type ) {
			$counts['media'] += $total;
		} elseif ( ! in_array( $type, $core_types, true ) ) {
			$counts['custom'] += $total;
		}
	}

	$counts['comments'] = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->comments}" );

	$term_taxonomies = $wpdb->term_taxonomy;
	$counts['terms'] = (int) $wpdb->get_var(
		"SELECT COUNT(*) FROM {$term_taxonomies}"
	);

	$counts['menus'] = count( wp_get_nav_menus() );

	return $counts;
}

function crt_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to use this tool.', 'content-reset-tool' ) );
	}

	$counts = crt_get_counts();
	$notice = isset( $_GET['crt_notice'] ) ? sanitize_key( wp_unslash( $_GET['crt_notice'] ) ) : '';
	$error  = isset( $_GET['crt_error'] ) ? sanitize_key( wp_unslash( $_GET['crt_error'] ) ) : '';
	?>
	<div class="wrap crt-wrap">
		<h1><?php esc_html_e( 'Content Reset Tool', 'content-reset-tool' ); ?></h1>

		<?php if ( 'complete' === $notice ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'Reset complete.', 'content-reset-tool' ); ?></strong>
				<?php esc_html_e( 'The selected WordPress content has been permanently removed.', 'content-reset-tool' ); ?></p>
			</div>
		<?php elseif ( 'confirmation' === $error ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'The confirmation text did not match.', 'content-reset-tool' ); ?></p></div>
		<?php elseif ( 'failed' === $error ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'The reset could not be completed. Check your server error log for details.', 'content-reset-tool' ); ?></p></div>
		<?php endif; ?>

		<div class="crt-card">
			<h2><?php esc_html_e( 'Start with a clean WordPress content layer', 'content-reset-tool' ); ?></h2>
			<p class="description">
				<?php esc_html_e( 'Designed for development, staging and testing sites. It removes content without reinstalling WordPress.', 'content-reset-tool' ); ?>
			</p>

			<div class="crt-stats">
				<div><strong><?php echo esc_html( number_format_i18n( $counts['posts'] ) ); ?></strong><span><?php esc_html_e( 'Posts', 'content-reset-tool' ); ?></span></div>
				<div><strong><?php echo esc_html( number_format_i18n( $counts['pages'] ) ); ?></strong><span><?php esc_html_e( 'Pages', 'content-reset-tool' ); ?></span></div>
				<div><strong><?php echo esc_html( number_format_i18n( $counts['custom'] ) ); ?></strong><span><?php esc_html_e( 'Custom content', 'content-reset-tool' ); ?></span></div>
				<div><strong><?php echo esc_html( number_format_i18n( $counts['media'] ) ); ?></strong><span><?php esc_html_e( 'Media items', 'content-reset-tool' ); ?></span></div>
				<div><strong><?php echo esc_html( number_format_i18n( $counts['comments'] ) ); ?></strong><span><?php esc_html_e( 'Comments', 'content-reset-tool' ); ?></span></div>
				<div><strong><?php echo esc_html( number_format_i18n( $counts['terms'] ) ); ?></strong><span><?php esc_html_e( 'Terms', 'content-reset-tool' ); ?></span></div>
			</div>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="crt-form">
				<input type="hidden" name="action" value="crt_reset">
				<?php wp_nonce_field( 'crt_reset_action', 'crt_nonce' ); ?>

				<h3><?php esc_html_e( 'Choose what to remove', 'content-reset-tool' ); ?></h3>

				<label class="crt-option">
					<input type="radio" name="crt_mode" value="content" checked>
					<span>
						<strong><?php esc_html_e( 'Content only', 'content-reset-tool' ); ?></strong>
						<small><?php esc_html_e( 'Deletes posts, pages, custom post types, comments, taxonomies and navigation menus. Keeps your Media Library.', 'content-reset-tool' ); ?></small>
					</span>
				</label>

				<label class="crt-option crt-danger">
					<input type="radio" name="crt_mode" value="content_media">
					<span>
						<strong><?php esc_html_e( 'Content + Media', 'content-reset-tool' ); ?></strong>
						<small><?php esc_html_e( 'Also permanently deletes Media Library items and their uploaded files.', 'content-reset-tool' ); ?></small>
					</span>
				</label>

				<div class="crt-warning">
					<strong><?php esc_html_e( 'This cannot be undone.', 'content-reset-tool' ); ?></strong>
					<p><?php esc_html_e( 'Do not use this on a production site unless you have a verified backup and intend to permanently remove the selected content.', 'content-reset-tool' ); ?></p>
				</div>

				<p>
					<label for="crt_confirmation">
						<?php esc_html_e( 'Type', 'content-reset-tool' ); ?>
						<strong>DELETE CONTENT</strong>
						<?php esc_html_e( 'to confirm.', 'content-reset-tool' ); ?>
					</label>
				</p>

				<input
					type="text"
					id="crt_confirmation"
					name="crt_confirmation"
					class="regular-text"
					autocomplete="off"
					placeholder="DELETE CONTENT"
					required
				>

				<p>
					<button type="submit" class="button button-primary button-large">
						<?php esc_html_e( 'Reset Selected Content', 'content-reset-tool' ); ?>
					</button>
				</p>
			</form>
		</div>
	</div>

	<script>
	(function () {
		const form = document.getElementById('crt-form');
		if (!form) return;
		form.addEventListener('submit', function (event) {
			const value = document.getElementById('crt_confirmation').value.trim();
			if (value !== 'DELETE CONTENT') {
				event.preventDefault();
				alert('<?php echo esc_js( __( 'Type DELETE CONTENT exactly to continue.', 'content-reset-tool' ) ); ?>');
				return;
			}
			if (!window.confirm('<?php echo esc_js( __( 'This will permanently delete the selected WordPress content. Continue?', 'content-reset-tool' ) ); ?>')) {
				event.preventDefault();
			}
		});
	})();
	</script>
	<?php
}

add_action( 'admin_post_crt_reset', 'crt_handle_reset' );

function crt_handle_reset() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to perform this action.', 'content-reset-tool' ) );
	}

	check_admin_referer( 'crt_reset_action', 'crt_nonce' );

	$confirmation = isset( $_POST['crt_confirmation'] )
		? sanitize_text_field( wp_unslash( $_POST['crt_confirmation'] ) )
		: '';

	if ( 'DELETE CONTENT' !== $confirmation ) {
		wp_safe_redirect( add_query_arg( 'crt_error', 'confirmation', admin_url( 'tools.php?page=content-reset-tool' ) ) );
		exit;
	}

	$mode = isset( $_POST['crt_mode'] ) ? sanitize_key( wp_unslash( $_POST['crt_mode'] ) ) : 'content';

	try {
		crt_delete_comments();
		crt_delete_all_posts( 'content_media' === $mode );
		crt_delete_terms();
		crt_delete_menus();

		// Remove orphaned relationships/meta left behind by custom data.
		crt_clean_orphans();

		// Refresh rewrite rules after custom post types/content have been removed.
		flush_rewrite_rules();

		wp_safe_redirect( add_query_arg( 'crt_notice', 'complete', admin_url( 'tools.php?page=content-reset-tool' ) ) );
		exit;
	} catch ( Throwable $e ) {
		error_log( 'Content Reset Tool: ' . $e->getMessage() );
		wp_safe_redirect( add_query_arg( 'crt_error', 'failed', admin_url( 'tools.php?page=content-reset-tool' ) ) );
		exit;
	}
}

function crt_delete_comments() {
	$comments = get_comments(
		array(
			'status' => 'all',
			'number' => 0,
			'fields' => 'ids',
		)
	);

	foreach ( $comments as $comment_id ) {
		wp_delete_comment( (int) $comment_id, true );
	}
}

function crt_delete_all_posts( $delete_media ) {
	global $wpdb;

	// Query the posts table directly so custom post types are removed even
	// when the plugin/theme that registered them has already been deactivated.
	$ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} ORDER BY ID ASC" );

	foreach ( $ids as $post_id ) {
		$post_id = (int) $post_id;
		$post    = get_post( $post_id );

		if ( ! $post ) {
			continue;
		}

		if ( 'attachment' === $post->post_type ) {
			if ( $delete_media ) {
				wp_delete_attachment( $post_id, true );
			} else {
				// Keep the media item and its files.
				continue;
			}
		} else {
			wp_delete_post( $post_id, true );
		}
	}
}

function crt_delete_terms() {
	global $wpdb;

	$taxonomies = $wpdb->get_col( "SELECT DISTINCT taxonomy FROM {$wpdb->term_taxonomy}" );

	foreach ( $taxonomies as $taxonomy ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'fields'     => 'ids',
			)
		);

		if ( is_wp_error( $terms ) ) {
			continue;
		}

		foreach ( $terms as $term_id ) {
			wp_delete_term( (int) $term_id, $taxonomy );
		}
	}
}

function crt_delete_menus() {
	$menus = wp_get_nav_menus();

	foreach ( $menus as $menu ) {
		wp_delete_nav_menu( $menu->term_id );
	}
}

function crt_clean_orphans() {
	global $wpdb;

	$wpdb->query(
		"DELETE pm FROM {$wpdb->postmeta} pm
		LEFT JOIN {$wpdb->posts} p ON pm.post_id = p.ID
		WHERE p.ID IS NULL"
	);

	$wpdb->query(
		"DELETE tr FROM {$wpdb->term_relationships} tr
		LEFT JOIN {$wpdb->posts} p ON tr.object_id = p.ID
		WHERE p.ID IS NULL"
	);

	$wpdb->query(
		"DELETE cm FROM {$wpdb->commentmeta} cm
		LEFT JOIN {$wpdb->comments} c ON cm.comment_id = c.comment_ID
		WHERE c.comment_ID IS NULL"
	);
}
