<?php
if ( ! defined( 'ABSPATH' ) ) exit; 

/**
 * Handle Notice Dismissals securely on admin_init.
 */
add_action( 'admin_init', 'wpa_handle_notice_dismissals' );
function wpa_handle_notice_dismissals() {
    // Ensure the user has permission to manage options before processing dismissals
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $notices = array(
        'wpa_reviews_notice_hide',
        'wpa_patreon_notice_hide_v2',
        'wpa_extended_notice_hide'
    );

    foreach ( $notices as $notice_key ) {
        if ( isset( $_GET[$notice_key] ) && $_GET[$notice_key] == '1' ) {
            // Optional: Add nonce verification here if you wrap URLs in wp_nonce_url()
            update_option( $notice_key, 'yes' );
            
            // Clean up the URL to prevent re-triggering on refresh
            $redirect_url = remove_query_arg( array( $notice_key, '_wpnonce' ) );
            wp_safe_redirect( $redirect_url );
            exit;
        }
    }
}

add_action( 'admin_notices', 'wpa_admin_notices' );
function wpa_admin_notices(){
    // FOR OLD EXTENDED VERSION
    if ( is_plugin_active( 'wp-armour-extended/wp-armour-extended.php' ) ) {
        if ( isset( $GLOBALS['wpae_version'] ) && $GLOBALS['wpae_version'] < 1.17 ) {
            echo '<div class="notice notice-error is-dismissible">
                <p><strong style="color:#900;">IMPORTANT : </strong> You are using an older version of WP Armour Extended. Please update to 1.17 or above for it to work properly.</p>
            </div>';
        }       
    }

    if ( current_user_can( 'manage_options' ) ): // ONLY SHOW IF ADMIN

        // Shared stats calculation
        $installed_date   = strtotime( get_option( 'wpa_installed_date' ) );
        $today_date       = time();        
        $installed_days   = round( ( $today_date - $installed_date ) / ( 60 * 60 * 24 ) );
        $wpa_stats        = json_decode( get_option( 'wpa_stats' ), true );
        $all_spam_blocked = $wpa_stats ? intval( $wpa_stats['total']['all_time'] ) : 0;

        // FOR REVIEWS
        if ( get_option( 'wpa_reviews_notice_hide' ) != 'yes' ) {
            if ( $installed_days > 30 && $all_spam_blocked > 30 ) {
                echo '<div class="updated success" style="padding:14px; font-size:14px; line-height:2; color:#205225; background-color:#f4fbf4; border-left:4px solid #4caf50;">
                        Hey, WP Armour has blocked <strong>' . esc_html( $all_spam_blocked ) . '</strong> spam submissions till date - that’s awesome! Could you please do us a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.<br/>

                        <ul style="padding-left:20px; margin: 0; list-style-type: square;">
                            <li><a href="https://wordpress.org/support/plugin/honeypot/reviews/?filter=5" target="_blank">Ok, you deserve it</a></li>
                            <li><a href="https://dineshkarki.com.np/contact" target="_blank">I still have problem !!</a></li>
                            <li><a href="' . esc_url( admin_url( "admin.php?page=wp-armour&wpa_reviews_notice_hide=1" ) ) . '">I already did</a></li> 
                            <li><a href="' . esc_url( admin_url( "admin.php?page=wp-armour&wpa_reviews_notice_hide=1" ) ) . '" style="color: #555;">Hide this message</a></li>    
                        </ul>
                     </div>';
            }
        }

        // FOR PATREON
        if ( ! is_plugin_active( 'wp-armour-extended/wp-armour-extended.php' ) ) {
            if ( get_option( 'wpa_patreon_notice_hide_v2' ) != 'yes' ) {
                if ( $installed_days > 100 && $all_spam_blocked > 300 ) {
                    echo '<div class="updated success" style="padding:14px; font-size:14px; line-height:2; color:#205225; background-color:#f4fbf4; border-left:4px solid #ff424d;">
                            <strong>** WP Armour needs your help badly... **</strong><br/>
                            As an indie developer, fighting automated spam is a relentless full time mission. Keeping the WP Armour Basic version free, clean, and lightweight for everyone relies entirely on community backing.<br/>
                            If WP Armour has saved your site from hundreds of spam bots over time, could you consider fueling this mission on Patreon with just $1/month? Your small contribution helps ensure constant updates, security patches, and a spam-free future.<br/>
                            <ul style="padding-left:20px; margin: 0; list-style-type: square;">
                                <li><a href="https://www.patreon.com/wp_armour" target="_blank" style="color: #ff424d; font-weight: bold;">Join the Patreon Supporters Page ☕</a></li>
                                <li><a href="' . esc_url( admin_url( "admin.php?page=wp-armour&wpa_patreon_notice_hide_v2=1" ) ) . '" style="color: #555;">Hide this message</a></li>
                            </ul>
                     </div>';
                }
            }
        }

        // UPSELLING EXTENDED VERSION
        if ( get_option( 'wpa_extended_notice_hide' ) != 'yes' && ! is_plugin_active( 'wp-armour-extended/wp-armour-extended.php' ) ) {
            if ( $installed_days > 90 && $all_spam_blocked > 1000 ) {
                echo '<div class="updated success" style="padding:14px; font-size:14px; line-height:2; color:#205225; background-color:#f4fbf4; border-left:4px solid #0073aa;">
                        Hey, WP Armour has blocked <strong>' . esc_html( $all_spam_blocked ) . '</strong> spam submissions till date - that’s awesome!<br/>

                        Can you help us by purchasing our Extended Version? This will help us maintain and support the plugin in upcoming days and make it even better. Our Extended version starts from 19.99 USD and comes with yearly license, No API calls & Fully GDPR Compliant.<br/>

                        It has additional support including WooCommerce (Blocks card testing orders), Ajax and Multi page Gravity Forms, Easy Digital Downloads, QuForm, MC4WP: Mailchimp for WordPress and have Spammer blocking based on IP, Record Spam Submission and many more.

                        <ul style="padding-left:20px; margin: 0; list-style-type: square;">
                            <li><a href="https://dineshkarki.com.np/buy-wp-armour-extended" target="_blank" style="font-weight: bold;">I will help</a></li>
                            <li><a href="' . esc_url( admin_url( "admin.php?page=wp-armour&wpa_extended_notice_hide=1" ) ) . '" style="color: #555;">Hide this message</a></li>
                        </ul>
                 </div>';
            }
        }

    endif; // CAN MANAGE OPTION
}