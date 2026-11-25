<?php
/**
 * @package Leverage
 */

require_once ( get_template_directory() . '/inc/tgm-plugin-activation.php' );

function leverage_register_required_plugins() {

	$plugins = array(		
		array(
			'name'               => 'Envato Market',
			'slug'               => 'envato-market',
			'version'            => '2.0.11',
			'source'             => esc_url( 'https://codings.dev/package/plugins/envato-market.zip?ver=' . time() ),
			'required'           => true
		),
		array(
			'name'               => 'Leverage Extra',
			'slug'               => 'leverage-extra',
			'version'            => '1.2.0',
			'source'             => esc_url( 'https://codings.dev/package/plugins/leverage-extra.zip?ver=' . time() ),
			'required'           => true
		),
		array(
			'name'               => 'Advanced Custom Fields PRO',
			'slug'               => 'advanced-custom-fields-pro',
			'version'            => '6.2.4',
			'source'             => esc_url( 'https://codings.dev/package/plugins/advanced-custom-fields-pro.zip?ver=' . time() ),
			'required'           => true
		),
		array(
			'name'               => 'ACF: Font Awesome',
			'slug'               => 'advanced-custom-fields-font-awesome',
			'version'            => '4.0.6',
			'required'           => true
		),
		array(
			'name'               => 'Elementor',
			'slug'               => 'elementor',
			'version'            => '3.18.3',
			'required'           => true,
		),
		array(
			'name'               => 'Contact Form 7',
			'slug'               => 'contact-form-7',
			'version'            => '5.8.5',
			'required'           => true,
		),
		array(
			'name'               => 'One Click Demo Import',
			'slug'               => 'one-click-demo-import',
			'version'            => '3.2.0',
			'required'           => true
		),
	);

	$config = array(
		'id'           => 'leverage',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => false,
		'is_automatic' => false,
		'default_path' => false
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'leverage_register_required_plugins' );