<?php

namespace WP_GDPR\Classes;

class GdprHandler {
	public static function handleAjaxCalls() {
		$route = sanitize_text_field( $_REQUEST['route'] );
		if ( $route == 'update_config' ) {
			$gdpr_Con   = wp_unslash( $_REQUEST['gdprConfig'] );
			$gdprConfig = json_decode( trim( stripslashes( $gdpr_Con ) ), true );
			static::updateGdprOption( $gdprConfig );
		}
		if ( $route == 'get_gdprconfig' ) {
			static::get_gdpr();
		}
	}

	/**
	 * Fetch gdpr options from db.
	 *
	 * @return HTTP JSON Response
	 */
	public static function get_gdpr() {
		$config   = get_option( '_gdpr_option_consent', false );
		$defaults = self::getGDPRConfig();
		$config   = wp_parse_args( $config, $defaults );
		wp_send_json_success( array(
			'getGdprConfig' => $config,
		) );
	}

	public static function addGDPRNotice() {
		if ( is_admin() ) {
			return;
		}
		$hasCookie = wp_gdpr_is_accepted() || wp_gdpr_is_denied();
		if ( isset( $_GET['wp_gdpr_preview'] ) && current_user_can( Menu::managePermission() ) ) {
			$hasCookie = false;
		}
		if ( $hasCookie ) {
			return;
		}

		$config = get_option( '_gdpr_option_consent', false );
		if ( ! $config ) {
			return;
		}
		$template = ArrayHelper::get( $config, 'styleObj.selectedBanner' );

		if ( ! $template || $template == 'hide' ) {
			return;
		}

		wp_enqueue_script(
			'wp_gdpr_user_display',
			WP_GDPR_PLUGIN_DIR_URL . 'public/js/wp_gdpr_user_display.js',
			array( 'jquery' ),
			WP_GDPR_PLUGIN_DIR_VERSION,
			true
		);

		wp_localize_script( 'wp_gdpr_user_display', 'gpd_settings_vars', array(
			'delay'    => $config['settings']['delay'],
			'duration' => $config['settings']['duration'],
			'template' => $template
		) );

		$css = self::generateCSS( $config, $template );

		add_action( 'wp_head', function () use ( $css ) {
			echo $css;
		} );

		ob_start();
		include( WP_GDPR_PLUGIN_DIR_PATH . "views/frontend_consent.php" );
		$content = ob_get_clean();
		add_action( 'wp_footer', function () use ( $content ) {
			echo $content;
		} );
	}

	/**
	 *  Data Update when update button click..
	 */
	public static function updateGdprOption( $gdprConfig ) {
		update_option( '_gdpr_option_consent', $gdprConfig );
		wp_send_json_success( array(
			'message' => __( 'Successfully updated', 'wp_gdpr' )
		) );
	}

	/**
	 *  initially Added data..
	 */
	public static function populateDemoAddData() {
		if ( ! get_option( '_gdpr_option_consent' ) ) {
			$demoData = static::getGDPRConfig();
			add_option( '_gdpr_option_consent', $demoData, '', 'yes' );
		}
	}

	/**
	 *  Demo data..
	 */
	public static function getGDPRConfig() {
		return array(
			'styleObj' => array(
				'bottom'         => '0px',
				'background'     => '#A3549E',
				'color'          => 'white',
				'position'       => 'relative',
				'width'          => '100%',
				'padding'        => '0px',
				'left'           => '0px',
				'right'          => '0px',
				'borderRadius'   => '0px',
				'display'        => 'block',
				'selectedBanner' => 'banner_bottom'
			),

			'styleMsg' => array(
				'padding' => '15px',
				'margin'  => '0',
				'display' => 'inline-block',
				'color'   => '#fff'
			),

			'stylePolicy' => array(
				'color' => 'wheat'
			),

			'confirmationBtn' => array(
				'display'      => 'inline',
				'float'        => 'right',
				'margin-top'   => '10px',
				'margin-right' => '12px'
			),

			'styleDismissBtn' => array(
				'float'       => '',
				'marginTop'   => '0px',
				'marginRight' => '0px',
				'marginLeft'  => '10px',
				'background'  => '#152CB5',
				'borderColor' => '#152CB5',
				'color'       => '#fff',
				'display'     => ''
			),

			'settings' => array(
				'duration'          => '180',
				'declined_duration' => '7',
				'delay'             => '100',
				'showDeclineBtn'    => false
			),

			'message'        => 'This website uses cookies to ensure you get the best experience on our website.',
			'policyLinkText' => 'Learn More',
			'dismissBtnText' => 'Accept',
			'customLink'     => ''
		);
	}

	public static function generateCSS( $config, $template ) {
		ob_start();
		?>
        <style type="text/css">
            .wpgdpr_wrapper {
                background-color: <?php echo ArrayHelper::get($config, 'styleObj.background'); ?>;
                color: <?php echo ArrayHelper::get($config, 'styleObj.color'); ?>;
                z-index: 999999999;
                padding: 15px;
            }

            .wpgdpr_wrapper .wpgdpr_message {
                color: <?php echo ArrayHelper::get($config, 'styleMsg.color'); ?>;
                margin: 0px;
                padding: 0px;
            }

            .wpgdpr_wrapper .wpgdpr_actions .wpgdpr_button {
                cursor: pointer;
                display: inline-block;
            }

            .gdprDecBtn {
                margin-right: 10px;
                color: <?php echo ArrayHelper::get($config, 'styleMsg.color'); ?>;
            }

            .wpgdpr_wrapper .wpgdpr_actions .gdprAcptBtn {
                background-color: <?php echo ArrayHelper::get($config, 'styleDismissBtn.borderColor'); ?>;
                color: <?php echo ArrayHelper::get($config, 'styleDismissBtn.color'); ?>;
                padding: 0px 12px;
                border-radius: 5px;
            }

            .wpgdpr_wrapper .wpgdp_more_link {
                color: <?php echo ArrayHelper::get($config, 'styleObj.policy_link_color'); ?>;
            }

            <?php if($template == 'banner_top' || $template == 'banner_bottom'): ?>
            .wpgdpr_banner_top {
                margin: 0px;
                position: fixed;
                top: 0px;
                width: 100%;
                padding: 0px;
                z-index: 999999999999;
            }

            .wpgdpr_content_body {
                max-width: 1170px;
                margin: 0 auto;
                padding: 20px;
            }

            .wpgdpr_message {
                display: inline-block;
                padding-right: 2%;
                vertical-align: middle;
            }

            .wpgdpr_actions {
                display: inline-block;
            }

            .wpgdpr_banner_bottom {
                margin: 0px;
                position: fixed;
                bottom: 0px;
                width: 100%;
                padding: 0px;
                z-index: 999999999999;
            }

            <?php elseif($template == 'banner_left' || $template == 'banner_right'): ?>
            .wpgdpr_banner_left {
                position: fixed;
                bottom: 0px;
                left: 0px;
                border-top-right-radius: 10px;
            }

            .wpgdpr_banner_right {
                position: fixed;
                bottom: 0px;
                right: 0px;
                border-top-left-radius: 10px;
            }

            .wpgdpr_banner_left .wpgdpr_content_body, .wpgdpr_banner_right .wpgdpr_content_body {
                max-width: 350px;
                padding: 10px;
            }

            .wpgdpr_message {
                margin-bottom: 20px;
            }

            .wpgdpr_actions {
                text-align: right;
            }

            <?php endif; ?>

        </style>
		<?php
		return ob_get_clean();
	}

	public static function filterCookieStatus( $status ) {
		// For GDPR Cookie Consent
		if ( ! $status ) {
			if ( ArrayHelper::get( $_COOKIE, 'viewed_cookie_policy' ) == 'yes' ) {
				return true;
			}
		}
		// For Cookie Notice for GDPR
		if ( ! $status ) {
			if ( ArrayHelper::get( $_COOKIE, 'cookie_notice_accepted' ) ) {
				return true;
			}
		}
		// for gdpr-cookie-compliance
		if ( ! $status ) {
			$moverCookie = ArrayHelper::get( $_COOKIE, 'moove_gdpr_popup' );
			if ( $moverCookie ) {
				$moverCookie = stripslashes_deep( $moverCookie );
				$moverCookie = json_decode( $moverCookie, true );
				if ( $moverCookie && ! empty( $moverCookie['strict'] ) ) {
					return true;
				}
			}
		}
		// gdpr-cookie-compliance
		if(! $status) {
		    if(ArrayHelper::get($_COOKIE, 'catAccCookies')) {
		        return true;
            }
        }
		return $status;
	}
}
