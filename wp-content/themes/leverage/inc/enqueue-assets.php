<?php
/**
 * @package Leverage
 */

$h1_font_category = 'sans-serif';
$h2_font_category = 'sans-serif';
$h3_font_category = 'sans-serif';
$p_font_category  = 'sans-serif';

function leverage_google_fonts_url( $font ) {
	$font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'leverage' ) ) {
        $font_url = add_query_arg( 'family', urlencode( $font.':300,400,500,600,700' ), '//fonts.googleapis.com/css' );
    }
    return $font_url;
}

function leverage_enqueue_assets() {
	function enqueue_style( $id, $file ) {
		wp_enqueue_style( $id, get_template_directory_uri() . '/assets/' . $file, array(), wp_get_theme('leverage')->get( 'Version' ) );
	} 

	// Font Family Vars
	$h1_font = 'Default';
	$h2_font = 'Poppins';
	$h3_font = 'Poppins';
	$p_font  = 'Poppins';

	if ( function_exists( 'ACF' ) ) {
		$font_family = get_field( 'font_family', 'option' );
	
		if ( $font_family ) {
			if ( array_key_exists( 'h1_font', $font_family ) ) {
				$h1_font = $font_family['h1_font'];
			}
			if ( array_key_exists( 'h2_font', $font_family ) ) {
				$h2_font = $font_family['h2_font'];
			}
			if ( array_key_exists( 'h3_font', $font_family ) ) {
				$h3_font = $font_family['h3_font'];
			}
			if ( array_key_exists( 'p_font', $font_family ) ) {
				$p_font  = $font_family['p_font'];
			}
		}
	}

	if ( $h1_font !== 'custom' ) {
		if ( $h1_font === 'Default' ) {
			wp_enqueue_style( 'default-font', get_template_directory_uri() . '/assets/' . 'css/vendor/default-font.min.css', array(), wp_get_theme('leverage')->get( 'Version' ) );
		} else {
			wp_enqueue_style( sanitize_title( $h1_font ), leverage_google_fonts_url( $h1_font ), array(), wp_get_theme('leverage')->get( 'Version' ) );
		}
	}

	if ( $h2_font !== 'custom' ) {
		wp_enqueue_style( sanitize_title( $h2_font ), leverage_google_fonts_url( $h2_font ), array(), wp_get_theme('leverage')->get( 'Version' ) );
	}

	if ( $h3_font !== 'custom' ) {
		wp_enqueue_style( sanitize_title( $h3_font ), leverage_google_fonts_url( $h3_font ), array(), wp_get_theme('leverage')->get( 'Version' ) );
	}

	if ( $p_font !== 'custom' ) {
		wp_enqueue_style( sanitize_title( $p_font ), leverage_google_fonts_url( $p_font ), array(), wp_get_theme('leverage')->get( 'Version' ) );
	}

	if ( is_rtl() ) {
		enqueue_style( 'bootstrap-rtl', 'css/support/bootstrap.rtl.min.css' );
	} else {
		enqueue_style( 'bootstrap', 'css/vendor/bootstrap.min.css' );
	}

	enqueue_style( 'slider', 'css/vendor/slider.min.css' );
	wp_enqueue_style('main', get_template_directory_uri() . '/style.css', array(), wp_get_theme('leverage')->get( 'Version' ));

	if( is_child_theme() ) {
		wp_enqueue_style( 'child-main', get_stylesheet_uri(), array(), wp_get_theme('leverage')->get( 'Version' ));
		wp_enqueue_script( 'child-main', str_replace( 'style.css', 'main.js', get_stylesheet_uri() ), array( 'jquery' ), wp_get_theme('leverage')->get( 'Version' ), true );
	}

	enqueue_style( 'icons', 'css/vendor/icons.min.css' );
	enqueue_style( 'animation', 'css/vendor/animation.min.css' );
	enqueue_style( 'gallery', 'css/vendor/gallery.min.css' );
	enqueue_style( 'cookie-notice', 'css/vendor/cookie-notice.min.css' );
  enqueue_style( 'default', 'css/default.css' );

	if ( function_exists( 'ACF' ) ) {
		$theme_color = get_field( 'theme_color', 'option' );

		if ( $theme_color !== 'custom-color' && ! get_field( 'override_general_settings' ) ) {
			enqueue_style( 'theme-color', $theme_color );
		}
	}

	enqueue_style( 'wordpress', 'css/support/wordpress.css' );
	enqueue_style( 'leverage-contact-form-7', 'css/support/contact-form-7.css' );
	
	if ( class_exists( 'WooCommerce' ) ) {
		enqueue_style( 'woocommerce', 'css/support/woocommerce.css' );
	}

	if ( is_rtl() ) {
		enqueue_style( 'main-rtl', 'css/support/main.rtl.css' );
	}

    function enqueue_script( $id, $file ) {
        wp_enqueue_script( $id, get_template_directory_uri() . '/assets/' . $file, array( 'jquery' ), wp_get_theme('leverage')->get( 'Version' ), true );
    } 
    
    enqueue_script( 'jquery-easing', 'js/vendor/jquery.easing.min.js' );
    enqueue_script( 'jquery-inview', 'js/vendor/jquery.inview.min.js' );
    enqueue_script( 'popper', 'js/vendor/popper.min.js' );

	if ( is_rtl() ) {
		enqueue_script( 'bootstrap-rtl', 'js/support/bootstrap.rtl.min.js' );
	} else {
		enqueue_script( 'bootstrap', 'js/vendor/bootstrap.min.js' );
	}

  enqueue_script( 'ponyfill', 'js/vendor/ponyfill.min.js' );    
	enqueue_script( 'slider', 'js/vendor/slider.min.js' );
  enqueue_script( 'animation', 'js/vendor/animation.min.js' );
	enqueue_script( 'progress-radial', 'js/vendor/progress-radial.min.js' );
	enqueue_script( 'bricklayer', 'js/vendor/bricklayer.min.js' );
	enqueue_script( 'gallery', 'js/vendor/gallery.min.js' );
	enqueue_script( 'shuffle', 'js/vendor/shuffle.min.js' );
	enqueue_script( 'particles', 'js/vendor/particles.min.js' );
	enqueue_script( 'cookie-notice', 'js/vendor/cookie-notice.min.js' );
	enqueue_script( 'main', 'js/main.js' );
	
	if ( ! is_admin() ) {
        if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
    }
}
add_action( 'wp_enqueue_scripts', 'leverage_enqueue_assets' );

add_action('admin_init', 'add_init_admin_styles', 99);

function add_init_admin_styles() {	
	wp_register_style( 'init-admin', false );
	wp_enqueue_style( 'init-admin' );
	wp_add_inline_style( 'init-admin', '.acf-settings-wrap, .toplevel_page_leverage-release-notes, .appearance_page_one-click-demo-import { opacity: 0 }' );

	wp_register_script( 'init-admin', false );
	wp_enqueue_script( 'init-admin' );
	wp_add_inline_script('init-admin', 'jQuery(function($) { leverage_dir_uri = "'.get_template_directory_uri().'"; $(".acf-settings-wrap h1").text("Theme Settings"); }) ', 'after');
}

function leverage_enqueue_assets_admin_area() {
	wp_enqueue_style( 'icons', get_template_directory_uri() . '/assets/' . 'css/vendor/icons.min.css', array(), wp_get_theme('leverage')->get( 'Version' ) );
	wp_enqueue_style( 'admin', get_template_directory_uri() . '/assets/' . 'css/support/admin.css', array(), wp_get_theme('leverage')->get( 'Version' ) );
	wp_enqueue_script( 'admin', get_template_directory_uri() . '/assets/' . 'js/support/admin.js', array( 'jquery' ), wp_get_theme('leverage')->get( 'Version' ), 'in_footer' );
}
add_action( 'admin_head', 'leverage_enqueue_assets_admin_area' );

if ( function_exists( 'ACF' ) ) {
	function leverage_add_inline_style() {
		
		// Font Family Vars
		$h1_font = 'Default';
		$h2_font = 'Poppins';
		$h3_font = 'Poppins';
		$p_font  = 'Poppins';

		$font_family = get_field( 'font_family', 'option' );
	
		if ( $font_family ) {
			if ( array_key_exists( 'h1_font', $font_family ) ) {
				$h1_font = $font_family['h1_font'];
			}
			if ( array_key_exists( 'h2_font', $font_family ) ) {
				$h2_font = $font_family['h2_font'];
			}
			if ( array_key_exists( 'h3_font', $font_family ) ) {
				$h3_font = $font_family['h3_font'];
			}
			if ( array_key_exists( 'p_font', $font_family ) ) {
				$p_font  = $font_family['p_font'];
			}
		}

		$h1_font_category = $GLOBALS['h1_font_category'];
		$h2_font_category = $GLOBALS['h2_font_category'];
		$h3_font_category = $GLOBALS['h3_font_category'];
		$p_font_category  = $GLOBALS['p_font_category'];
		
		// Root open
		$inline_style =':root {';

		// Font Family	
		if ( $h1_font !== 'custom' ) {
			if ( $h1_font === 'Default' ) {
				$inline_style .= '--h1-font: "'.$h1_font.'";';
			} else {
				$inline_style .= '--h1-font: '.$h1_font.', '.$h1_font_category.';';
			}
		}
		if ( $h2_font !== 'custom' ) {
			$inline_style .= '--h2-font: '.$h2_font.', '.$h2_font_category.';';
		}
		if ( $h3_font !== 'custom' ) {
			$inline_style .= '--h3-font: '.$h3_font.', '.$h3_font_category.';';
		}
		if ( $p_font !== 'custom' ) {
			$inline_style .= '--p-font: '.$p_font.', '.$p_font_category.';';
		}

		// Light Text Color
		$light_text_color = get_field( 'light_text_color', 'option' );
		if ( $light_text_color ) {
			$inline_style .= esc_attr( '--primary-p-color: '.$light_text_color.';' );	
		}

		// Dark Text Color
		$dark_text_color  = get_field( 'dark_text_color', 'option' );
		if ( $dark_text_color ) {
			$inline_style .= esc_attr( '--secondary-p-color: '.$dark_text_color.';' );
		}

		// Typography [laptop]
		$font_size = get_field( 'font_size', 'option' );
		if ( $font_size ) {
			if ( array_key_exists( 'h1_size', $font_size ) ) {
				$inline_style .= esc_attr( '--h1-size: '.$font_size['h1_size'].'rem;' );
			}	
			if ( array_key_exists( 'h2_size', $font_size ) ) {
				$inline_style .= esc_attr( '--h2-size: '.$font_size['h2_size'].'rem;' );
			}	
			if ( array_key_exists( 'h3_size', $font_size ) ) {
				$inline_style .= esc_attr( '--h3-size: '.$font_size['h3_size'].'rem;' );
			}	
			if ( array_key_exists( 'p_size', $font_size ) ) {
				$inline_style .= esc_attr( '--p-size: '.$font_size['p_size'].'rem;' );	
			}		
		}

		$font_weight = get_field( 'font_weight', 'option' );
		if ( $font_weight ) {
			if ( array_key_exists( 'h1_weight', $font_weight ) ) {
				$inline_style .= esc_attr( '--h1-weight: '.$font_weight['h1_weight'].';' );
			}
			if ( array_key_exists( 'h2_weight', $font_weight ) ) {
				$inline_style .= esc_attr( '--h2-weight: '.$font_weight['h2_weight'].';' );
			}
			if ( array_key_exists( 'h3_weight', $font_weight ) ) {
				$inline_style .= esc_attr( '--h3-weight: '.$font_weight['h3_weight'].';' );
			}
			if ( array_key_exists( 'p_weight', $font_weight ) ) {
				$inline_style .= esc_attr( '--p-weight: '.$font_weight['p_weight'].';' );			
			}	
		}

		// Typography [mobile]
		$font_m_size = get_field( 'font_m_size', 'option' );
		if ( $font_m_size ) {
			if ( array_key_exists( 'h1_size', $font_m_size ) ) {
				$inline_style .= esc_attr( '--h1-m-size: '.$font_m_size['h1_size'].'rem;' );
			}
			if ( array_key_exists( 'h2_size', $font_m_size ) ) {
				$inline_style .= esc_attr( '--h2-m-size: '.$font_m_size['h2_size'].'rem;' );
			}
			if ( array_key_exists( 'h3_size', $font_m_size ) ) {
				$inline_style .= esc_attr( '--h3-m-size: '.$font_m_size['h3_size'].'rem;' );
			}
			if ( array_key_exists( 'p_size', $font_m_size ) ) {
				$inline_style .= esc_attr( '--p-m-size: '.$font_m_size['p_size'].'rem;' );
			}
		}

		$font_m_weight = get_field( 'font_m_weight', 'option' );
		if ( $font_m_weight ) {	
			if ( array_key_exists( 'h1_weight', $font_m_weight ) ) {
				$inline_style .= esc_attr( '--h1-m-weight: '.$font_m_weight['h1_weight'].';' );
			}
			if ( array_key_exists( 'h2_weight', $font_m_weight ) ) {
				$inline_style .= esc_attr( '--h2-m-weight: '.$font_m_weight['h2_weight'].';' );
			}
			if ( array_key_exists( 'h3_weight', $font_m_weight ) ) {
				$inline_style .= esc_attr( '--h3-m-weight: '.$font_m_weight['h3_weight'].';' );
			}
			if ( array_key_exists( 'p_weight', $font_m_weight ) ) {
				$inline_style .= esc_attr( '--p-m-weight: '.$font_m_weight['p_weight'].';' );
			}	
		}

		// Brand
		$nav_brand_height = get_field( 'logo_height', 'option' );
		if ( $nav_brand_height ) {
			$inline_style .= esc_attr( '--nav-brand-height: '.$nav_brand_height.'px;' );
		}

		// Footer Brand
		$footer_logo_height = get_field( 'footer_logo_height', 'option' );
		if ( $footer_logo_height ) {
			$inline_style .= esc_attr( '--footer-brand-height: '.$footer_logo_height.'px;' );
		}

		// Page Settings
		if ( get_field( 'override_general_settings' ) ) {

			if ( get_field( 'header_bg_color' ) ) { $header_bg_color = get_field( 'header_bg_color' ); }
			else { $header_bg_color = get_field( 'header_bg_color', 'option' ); }

			if ( get_field( 'nav_item_color' ) ) { $nav_item_color = get_field( 'nav_item_color' ); }
			else { $nav_item_color = get_field( 'nav_item_color', 'option' ); }

			if ( get_field( 'top_nav_item_color' ) ) { $top_nav_item_color = get_field( 'top_nav_item_color' ); }
			else { $top_nav_item_color = get_field( 'top_nav_item_color', 'option' ); }

			if ( get_field( 'hero_bg_color' ) ) { $hero_bg_color = get_field( 'hero_bg_color' ); }
			else { $hero_bg_color = get_field( 'hero_bg_color', 'option' ); }
			
		} else {			
			$header_bg_color    = get_field( 'header_bg_color', 'option' );
			$nav_item_color     = get_field( 'nav_item_color', 'option' );
			$top_nav_item_color = get_field( 'top_nav_item_color', 'option' );
			$hero_bg_color      = get_field( 'hero_bg_color', 'option' );
		}

		if ( $header_bg_color && $nav_item_color && $top_nav_item_color && $hero_bg_color ) {
			$inline_style .= esc_attr( '--header-bg-color: '.$header_bg_color.';' );
			$inline_style .= esc_attr( '--nav-item-color: '.$nav_item_color.';' );
			$inline_style .= esc_attr( '--top-nav-item-color: '.$top_nav_item_color.';' );
			$inline_style .= esc_attr( '--hero-bg-color: '.$hero_bg_color.';' );
		}

		// Theme Color
		$theme_color     = get_field( 'theme_color', 'option' );

		// Page Settings 
		if ( get_field( 'override_general_settings' ) ) {

			$primary_color   = get_field( 'primary_color' );
			$secondary_color = get_field( 'secondary_color' );

			if ( $primary_color ) {
				$inline_style .= esc_attr( '--lvr-primary-color: '.$primary_color.';' );

			} else {
				$primary_color   = get_field( 'primary_color', 'option' );
	
				if ( $theme_color == 'custom-color' ) {
					$inline_style .= esc_attr( '--lvr-primary-color: '.$primary_color.';' );
				}
			}

			if ( $secondary_color ) {
				$inline_style .= esc_attr( '--lvr-secondary-color: '.$secondary_color.';' );

			} else {
				$secondary_color = get_field( 'secondary_color', 'option' );
	
				if ( $theme_color == 'custom-color' ) {
					$inline_style .= esc_attr( '--lvr-secondary-color: '.$secondary_color.';' );
				}
			}

			$button_mode = get_field( 'button_mode' );

			if ( $button_mode === 'default' ) {
				$primary_button_color = get_field( 'primary_button_color' );
				$primary_button_hover_color = get_field( 'primary_button_hover_color' );
				
				if ( $primary_button_color ) {
					$inline_style .= esc_attr( '--primary-button-color: '.$primary_button_color.';' );
				}
				
				if ( $primary_button_hover_color ) {
					$inline_style .= esc_attr( '--primary-button-hover-color: '.$primary_button_hover_color.';' );
				}
			}

			elseif ( $button_mode === 'outlined' ) {
				$dark_button_color = get_field( 'outlined_button_color' );
				$dark_button_hover_color = get_field( 'outlined_button_hover_color' );
				$dark_button_background_color = get_field( 'outlined_button_background_color' );

				if ( $dark_button_color ) {
					$inline_style .= esc_attr( '--dark-button-color: '.$dark_button_color.';' );
				}

				if ( $dark_button_hover_color ) {
					$inline_style .= esc_attr( '--dark-button-hover-color: '.$dark_button_hover_color.';' );
				}

				if ( $dark_button_background_color ) {
					$inline_style .= esc_attr( '--dark-button-bg-color: '.$dark_button_background_color.';' );
				}
			}
		} 
		
		// General Settings
		else {
			$primary_color   = get_field( 'primary_color', 'option' );
			$secondary_color = get_field( 'secondary_color', 'option' );

			if ( $theme_color == 'custom-color' ) {
				$inline_style .= esc_attr( '--lvr-primary-color: '.$primary_color.';' );
				$inline_style .= esc_attr( '--lvr-secondary-color: '.$secondary_color.';' );
			}
		}

		// Root close
		$inline_style .='} ';

		// Hero Color
		$hero_title_color = get_field( 'hero_title_color', 'option' );
		if ( $hero_title_color ) {
			if ( array_key_exists( 'primary_color', $hero_title_color ) && array_key_exists( 'secondary_color', $hero_title_color ) ) {
				$inline_style .= '.hero .slide-content .title { background-image: -webkit-linear-gradient(45deg, '.$hero_title_color['secondary_color'].' 15%, '.$hero_title_color['primary_color'].' 65%); background-image: linear-gradient(45deg, '.$hero_title_color['secondary_color'].' 15%, '.$hero_title_color['primary_color'].' 65%); }';
			}
		}

		$hero_description_color = get_field( 'hero_description_color', 'option' );
		if ( $hero_description_color ) {
			if ( array_key_exists( 'color', $hero_description_color ) ) {
				$inline_style .= '.hero .slide-content .description, .breadcrumb-item a:not(.btn), .breadcrumb-item+.breadcrumb-item::before { color: '.$hero_description_color['color'].'; }';
			}
		}		

		// Blog Options
		$blog_layout = get_field( 'blog_layout', 'option' );

		if ( $blog_layout ) {
			if ( array_key_exists( 'image_height', $blog_layout ) ) {
				if ( $blog_layout['image_height'] ) {
					$inline_style .= '.showcase .card .image-over img { min-height: '.esc_attr( $blog_layout['image_height'] ).'px; }';
				}
			}
		}

		// Dark & Light Switcher
		$dark_and_light_switcher = get_field( 'dark_and_light_switcher', 'option' );

		if ( $dark_and_light_switcher && array_key_exists( 'enable', $dark_and_light_switcher ) ) {
			if ( $dark_and_light_switcher['enable'] ) {

				$dark_and_light_switcher_opacity  = ( $dark_and_light_switcher['opacity_control'] / 100 );

				if ( $dark_and_light_switcher['position'] == 'right' ) { 
					$inline_style .= '.dark-and-light-switcher { right: 25px; } .dark-and-light-switcher { left: initial; }';
				} else {
					$inline_style .= '.dark-and-light-switcher { left: 25px; } .dark-and-light-switcher { right: initial; }';
				}
				
				$inline_style .= '.dark-and-light-switcher { opacity: '.esc_attr( $dark_and_light_switcher_opacity ).'; }';
			}
		}
		
		// Custom CSS
		if ( get_field( 'custom_css', 'option' ) ) {
			$inline_style .= get_field( 'custom_css', 'option' );
		}

		// reCAPTCHA
		$recaptcha = get_field( 'recaptcha', 'option' );
		if ( $recaptcha ) {
			if ( array_key_exists( 'enable_recaptcha', $recaptcha ) && array_key_exists( 'display_recaptcha_badge', $recaptcha ) ) {
				if ( ! $recaptcha['enable_recaptcha'] || $recaptcha['enable_recaptcha'] && $recaptcha['display_recaptcha_badge'] ) {
					$inline_style .= '.grecaptcha-badge { visibility: visible; z-index: 1 }';
				}
			}
		}

		wp_add_inline_style( 'default', $inline_style );

		$font_family        = get_field( 'font_family', 'option' );
		$custom_font_family = get_field( 'custom_font_family', 'option' );

		if ( $custom_font_family ) {
			
			$h1_font = $font_family['h1_font'];
			$h2_font = $font_family['h2_font'];
			$h3_font = $font_family['h3_font'];
			$p_font  = $font_family['p_font'];

			if ( array_key_exists( 'h1_font', $custom_font_family ) ) {
				$h1_custom_font = $custom_font_family['h1_font'];
			}
			if ( array_key_exists( 'h2_font', $custom_font_family ) ) {
				$h2_custom_font   = $custom_font_family['h2_font'];
			}
			if ( array_key_exists( 'h3_font', $custom_font_family ) ) {
				$h3_custom_font   = $custom_font_family['h3_font'];
			}
			if ( array_key_exists( 'p_font', $custom_font_family ) ) {
				$p_custom_font = $custom_font_family['p_font'];
			}

			$custom_font_style = '';

			if ( $h1_font == 'custom' && $h1_custom_font ) {
				$custom_font_style .= '@font-face { font-family: "h1-custom"; src: url("'. $h1_custom_font .'") format("woff"); }';
				$custom_font_style .= ':root { --h1-font: h1-custom; }';				
			}

			if ( $h2_font == 'custom' && $h2_custom_font ) {
				$custom_font_style .= '@font-face { font-family: "h2-custom"; src: url("'. $h2_custom_font .'") format("woff"); }';
				$custom_font_style .= ':root { --h2-font: h2-custom; }';				
			}

			if ( $h3_font == 'custom' && $h3_custom_font ) {
				$custom_font_style .= '@font-face { font-family: "h3-custom"; src: url("'. $h3_custom_font .'") format("woff"); }';
				$custom_font_style .= ':root { --h3-font: h3-custom; }';				
			}

			if ( $p_font == 'custom' && $p_custom_font ) {
				$custom_font_style .= '@font-face { font-family: "p-custom"; src: url("'. $p_custom_font .'") format("woff"); }';
				$custom_font_style .= ':root { --p-font: p-custom; }';				
			}

			wp_add_inline_style( 'default', $custom_font_style );
		}
	}
	add_action( 'wp_enqueue_scripts', 'leverage_add_inline_style' );
}

function leverage_custom_js() {
	if ( function_exists( 'ACF' ) ) {
		if ( get_field( 'custom_js', 'option' ) ) {
			function leverage_add_inline_scripts() {			
				$inline_script = get_field( 'custom_js', 'option' );
				wp_add_inline_script('main', $inline_script, 'after');
			}
			add_action('wp_enqueue_scripts', 'leverage_add_inline_scripts');
		}
	}
}
add_action( 'init', 'leverage_custom_js' );

if ( ! function_exists( 'replace_font_awesome' ) ) {

	function replace_font_awesome() {
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/vendor/icons-fa.min.css', array(), '5.6' );
	}

	add_action( 'wp_enqueue_scripts', 'replace_font_awesome', 3 );
	add_action( 'elementor/frontend/after_enqueue_styles', function () { wp_dequeue_style( 'font-awesome' ); } );
}