<div class="wpgdpr_wrapper wpgdpr_<?php echo $template; ?>" id='wpgdpr_banner_bottom'>
    <div class="wpgdpr_content_body">
        <div class="wpgdpr_message">
			<?php echo $config['message']; ?>
			<?php if ( ! empty( $config['customLink'] ) && ! empty( $config['policyLinkText'] ) ): ?>
                <a class="wpgdp_more_link" href="<?php echo esc_url( $config['customLink'] ); ?>" target='_blank'>
					<?php echo $config['policyLinkText']; ?>
                </a>
			<?php endif; ?>
        </div>
        <div class="wpgdpr_actions">
			<?php if ( $config['settings']['showDeclineBtn'] ): ?>
                <div class='wpgdpr_button gdprDecBtn'><?php echo $config['settings']['decline_button_text']; ?></div>
			<?php endif; ?>
            <div class='wpgdpr_button gdprAcptBtn'>
				<?php echo wp_kses_post( $config['dismissBtnText'] ); ?>
            </div>
        </div>
    </div>
</div>