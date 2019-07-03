<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage washing-center
 * @since 1.0
 * @version 1.4
 */

?>
<div class="site-info">
	<p><?php echo esc_html(get_theme_mod('washing_center_footer_copy',__('Washing Center WordPress Theme By','washing-center'))); ?> <?php washing_center_credit(); ?></p>
</div>