<?php
/**
 * Admin
 *
 * General admin adjustments.
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

class Admin {

	/**
	 * Initialize
	 */
	public static function init() {
		// Remove version from footer.
		add_action( 'admin_menu', [ self::class, 'admin_no_footer_version' ] );
		add_action( 'network_admin_menu', [ self::class, 'admin_no_footer_version' ] );

		// Change admin footer text.
		add_filter( 'admin_footer_text', [ self::class, 'change_admin_footer_text' ] );

		// Remove the help tab.
		add_filter( 'admin_head', [ self::class, 'remove_help_tab' ] );

		// Add our help and support widget.
		add_action( 'admin_footer', [ self::class, 'add_help_widget' ] );
	}

	/**
	 * Change Admin Footer Text
	 *
	 * @return string
	 */
	public static function change_admin_footer_text() {
		/* translators: 1. Site Name */
		$new_text = sprintf( __( 'Thank you for creating with <a href="https://wordpress.org">WordPress</a> and <a href="https://www.bernskioldmedia.com/en/?utm_source=clientsite&utm_medium=dashboard_link&utm_campaign=%1$s">Bernskiold Media</a>.',
			'bm-wp-experience' ), get_bloginfo( 'name' ) );

		return $new_text;
	}

	/**
	 * Admin No Footer Version
	 *
	 * @return void
	 */
	public static function admin_no_footer_version() {
		remove_filter( 'update_footer', 'core_update_footer' );
	}

	/**
	 * Remove the help tabs.
	 */
	public static function remove_help_tab() {
		get_current_screen()->remove_help_tabs();
	}

	public static function add_help_widget() {
		if ( false === apply_filters( 'bm_wpexp_show_admin_page_support', true ) ) {
			return;
		}

		$user = get_user_by('ID', get_current_user_id());

		?>
		<script type="text/javascript" defer>
			! function( e, t, n ) {
				function a() {
					var e = t.getElementsByTagName( 'script' )[0], n = t.createElement( 'script' );
					n.type = 'text/javascript', n.async = ! 0, n.src = 'https://beacon-v2.helpscout.net', e.parentNode.insertBefore( n, e )
				}

				if ( e.Beacon = n = function( t, n, a ) {
					e.Beacon.readyQueue.push( { method: t, options: n, data: a } )
				}, n.readyQueue = [], 'complete' === t.readyState ) return a();
				e.attachEvent ? e.attachEvent( 'onload', a ) : e.addEventListener( 'load', a, ! 1 )
			}( window, document, window.Beacon || function() {
			} );</script>
		<script type="text/javascript" defer>
			window.Beacon( 'init', '400d429a-e257-4a5d-bd60-97953b3a81c4' );
			window.Beacon( 'identify', {
				name: '<?php echo esc_js($user->first_name . ' '. $user->last_name); ?>',
				email: '<?php echo esc_js($user->user_email); ?>'
			} )
		</script>
		<?php
	}

}

Admin::init();
