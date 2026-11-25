<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('wpae_get_blocked_integrations') || !in_array('wp_login_form', wpae_get_blocked_integrations())) :	

	function wpa_wplogin_add_initiator_field() {
	    echo '<input type="hidden" id="wpa_initiator" class="wpa_initiator" name="wpa_initiator" value="" />';
	}

	add_action('lostpassword_form', 'wpa_wplogin_add_initiator_field');
	add_action('woocommerce_lostpassword_form', 'wpa_wplogin_add_initiator_field');
	 
	add_action( 'login_form', 'wpa_wplogin_add_initiator_field' );
	add_action( 'woocommerce_login_form', 'wpa_wplogin_add_initiator_field' ); // FIX FOR WOOCOMMERCE LOGIN.


	/**
	 * Detect a Wordfence Login Security passkey (WebAuthn) login-completion request.
	 *
	 * The wp-login form finishes passkey login via admin-ajax.php with
	 * action=wordfence_ls_finish_passkey_login (required POST: token, credential).
	 * Wordfence also exposes an internal REST route that calls the same
	 * wp_authenticate() path.
	 *
	 * These requests do not submit the honeypot fields used by wpa_check_is_spam().
	 *
	 * @return bool
	 */
	function wpa_is_wordfence_passkey_login_request() {
		$action = ( isset( $_REQUEST['action'] ) && is_string( $_REQUEST['action'] ) ) ? $_REQUEST['action'] : '';
		if ( 'wordfence_ls_finish_passkey_login' === $action && isset( $_POST['token'], $_POST['credential'] ) ) {
			return true;
		}

		$route = '';
		if ( isset( $GLOBALS['wp'] ) && is_object( $GLOBALS['wp'] ) && isset( $GLOBALS['wp']->query_vars['rest_route'] ) ) {
			$route = (string) $GLOBALS['wp']->query_vars['rest_route'];
		} elseif ( ! empty( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
			$route = (string) $_SERVER['REQUEST_URI'];
		}

		if ( $route !== '' && false !== strpos( $route, '/wordfence-login-security/v1/internal/passkey-login/finish' ) ) {
			return true;
		}

		return false;
	}

	function wpae_wplogin_extra_validation( $user, $username, $password ) {
		// A prior filter (e.g. Wordfence passkey at priority 5) may already have a WP_User.
		if ( $user instanceof WP_User ) {
			return $user;
		}

		if ( apply_filters( 'wpa_skip_authenticate_check', false, $user, $username, $password ) ) {
			return $user;
		}

		if ( wpa_is_wordfence_passkey_login_request() ) {
			return $user;
		}

	    if ( ! empty( $_POST ) ) {
		    if (wpa_check_is_spam($_POST)){
		    	$postData = $_POST;
				$postData['pwd']	= '**removed**';
				do_action('wpa_handle_spammers','wplogin', $postData);
				return new WP_Error( 'error', $GLOBALS['wpa_error_message']);
			}
		}

		return $user;
	}
	add_filter( 'authenticate', 'wpae_wplogin_extra_validation', 10, 3 );


	function wpae_lostpassword_extra_validation( $errors ) {
		if ( is_admin() ) { return; }

	    if (wpa_check_is_spam($_POST)){
				do_action('wpa_handle_spammers','losspassword', $_POST);
				$errors->add( 'user_login', __($GLOBALS['wpa_error_message']) );
		}
	}
	add_action( 'lostpassword_post', 'wpae_lostpassword_extra_validation' );

endif;