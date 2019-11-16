<?php
/**
 * Authors Tweaks
 **/

class Authors {

	/**
	 * On these domain names, agency users may be indexed.
	 * Includes sub-domains.
	 */
	protected const WHITELISTED_DOMAINS = [
		'bernskioldmedia.com',
		'bernskioldmedia.se',
		'bmedia.dev',
		'bmdev.zone',
	];

	/**
	 * Agency users are those with e-mails
	 * in these domains (including sub-domains).
	 */
	protected const EMAIL_DOMAINS = [
		'bernskioldmedia.com',
		'bernskioldmedia.se',
	];

	/**
	 * Initialize
	 */
	public static function init() {
		add_action( 'wp', [ self::class, 'maybe_disable_author_archive' ] );
	}

	/**
	 * We want to disable the author archive so that
	 * agency users never get indexed on client sites.
	 */
	public static function maybe_disable_author_archive() {

		if ( ! is_author() ) {
			return;
		}

		$is_author_disabled = false;
		$author             = get_queried_object();
		$current_domain     = parse_url( get_site_url(), PHP_URL_HOST );

		// Perform partial match on domains to catch subdomains or variation of domain name
		$filtered_domains = array_filter( self::get_whitelisted_domains(), function ( $domain ) use ( $current_domain ) {
			return false !== stripos( $current_domain, $domain );
		} );

		/**
		 * The user in the query must have an email,
		 * or if we allow indexing of BM users.
		 */
		if ( ! empty( $filtered_domains ) || empty( $author->data->user_email ) || true === apply_filters( 'bm_wpexp_allow_bm_author_index', false ) ) {
			return;
		}

		foreach ( self::get_email_domains() as $domain ) {
			if ( false !== stripos( $author->data->user_email, $domain ) ) {
				$is_author_disabled = true;
			}
		}

		if ( true === $is_author_disabled ) {
			wp_safe_redirect( '/', '301' );
			exit();
		}
	}

	/**
	 * Get Whitelisted Domains
	 *
	 * @return array
	 */
	public static function get_whitelisted_domains() {
		return apply_filters( 'bm_wpexp_authors_whitelisted_domains', self::WHITELISTED_DOMAINS );
	}

	/**
	 * Get E-Mail Domains
	 *
	 * @return array
	 */
	public static function get_email_domains() {
		return apply_filters( 'bm_wpexp_authors_email_domains', self::EMAIL_DOMAINS );
	}

}

Authors::init();
