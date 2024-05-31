<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package   Bonus_Calculator
 * @subpackage Bonus_Calculator/admin/partials
 */
?>

<div class="wrap">
	<h1>Bonus Calculator Settings</h1>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'bonus_calculator_settings_group' );
		do_settings_sections( 'bonus_calculator_settings' );
		submit_button();
		?>
	</form>
</div>