<?php
/**
 * Support
 *
 * Adds in support functions in the backend to let the user
 * easily get in touch with Bernskiold Media support.
 *
 * @package BernskioldMedia\WP\Experience
 **/

namespace BernskioldMedia\WP\Experience;

/**
 * Class Support
 *
 * @package BernskioldMedia\WP\Experience
 */
class Support {

	/**
	 * Initialize
	 */
	public static function init() {
		add_action( 'admin_init', [ self::class, 'load_beacon' ] );
	}

	/**
	 * Set up the Beacon code, the small inline support widget
	 * which is loaded on admin pages and offers help docs
	 * and contact actions.
	 */
	public static function load_beacon() {

		// Hide the beacon if disabled.
		if ( false === apply_filters( 'bm_wpexp_show_support', true ) ) {
			return;
		}

		// Get current user object.
		$current_user = wp_get_current_user();

		// User data.
		$first_name = $current_user->user_firstname;
		$last_name  = $current_user->user_lastname;
		$full_name  = $first_name . ' ' . $last_name;
		$email      = $current_user->user_email;

		// Get current admin screen.
		$screen     = get_current_screen();
		$screen_id  = isset($screen->id) ? $screen->id : '';

		// Get current URL
		$url = self::get_current_url();

		// Get User Locale.
		$locale = get_user_locale( $current_user->ID );

		ob_start(); ?>
		<script type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});</script>
		<script type="text/javascript">

			window.Beacon( 'init', '400d429a-e257-4a5d-bd60-97953b3a81c4' );

			Beacon( 'identify', {
				name: '<?php echo esc_js( $full_name ); ?>',
				email: '<?php echo esc_js( $email ); ?>',
				avatar: '<?php echo esc_url( get_avatar_url( $current_user->ID ) ); ?>'
			} );

			Beacon( 'session-data', {
				"Website": '<?php echo esc_js( get_bloginfo( 'name' ) ); ?>',
				"Current Admin Screen": '<?php echo esc_js( $screen ); ?>',
				"Current URL": '<?php echo esc_js( $url ); ?>'
			} );

			window.Beacon( "init", "400d429a-e257-4a5d-bd60-97953b3a81c4" );

		</script>

		<?php
		echo ob_get_clean();
	}

	/**
	 * Get the current URL.
	 *
	 * @return string
	 */
	protected static function get_current_url() {
		$current_url = ( @$_SERVER["HTTPS"] == "on" ) ? "https://" : "http://";
		$current_url .= $_SERVER["SERVER_NAME"];

		if ( $_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443" ) {
			$current_url .= ":" . $_SERVER["SERVER_PORT"];
		}

		$current_url .= $_SERVER["REQUEST_URI"];

		return esc_url( $current_url );
	}

}

Support::init();
