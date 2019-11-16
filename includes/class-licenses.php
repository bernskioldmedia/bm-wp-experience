<?php
/**
 * Licenses Setup
 *
 * Some plugins we use extensively don't allow license
 * keys to be set as constants. This is a major pain for
 * unlimited license plugins. So we iinterface with them here.
 **/

class Licenses {

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_filter( 'pre_option_acf_pro_license', [ self::class, 'acf_license_key' ] );
	}

	/**
	 * Add ACF License Key
	 *
	 * @param string $pre
	 *
	 * @return string
	 */
	public static function acf_license_key( $pre ) {

		if ( ! defined( 'ACF_PRO_KEY' ) || empty( ACF_PRO_KEY ) ) {
			return $pre;
		}

		$data = [
			'key' => ACF_PRO_KEY,
			'url' => home_url(),
		];

		return base64_encode( serialize( $data ) ); // @codingStandardsIgnoreLine
	}

}

Licenses::hooks();
