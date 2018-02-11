<?php

/**
 * Build the run custom field meta boxes.
 *
 * @link       https://raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Strided_App
 * @subpackage Strided_App/admin/partials
 */
?>

<div class="run-information">

	<input type="hidden" name="run_information_meta_box_nonce" value="<?php esc_attr_e( wp_create_nonce('run_information_meta_box_nonce') ); ?>" />

	<label for="run_arena">Arena</label>
	<select id="run_arena" name="run_arena">
		<option disabled value hidden <?php if ('' == $run_info[ '_run_arena' ][0]) { echo 'selected'; } ?> ></option>
		<?php foreach ($arenas->posts as $arena) : ?>
		<option value="<?php echo $arena->ID; ?>" <?php if ($arena->ID == $run_info[ '_run_arena' ][0]) { echo 'selected'; } ?> ><?php echo $arena->post_title; ?></option>
		<?php endforeach; ?>
	</select><br />

	<label for="run_horse">Horse</label>
	<select id="run_horse" name="run_horse">
		<option disabled value hidden <?php if ('' == $run_info[ '_run_horse' ][0]) { echo 'selected'; } ?> ></option>
		<?php foreach ($horses->posts as $horse) : ?>
		<option value="<?php echo $horse->ID; ?>" <?php if ($horse->ID == $run_info[ '_run_horse' ][0]) { echo 'selected'; } ?> ><?php echo $horse->post_title; ?></option>
		<?php endforeach; ?>
	</select><br />

	<label for="run_placing">Placing</label>
	<input id="run_placing" name="run_placing" value="<?php esc_attr_e( $run_info[ '_run_placing' ][0] ); ?>" /><br />

	<label for="run_class">Class</label>
	<input id="run_class" name="run_class" value="<?php esc_attr_e( $run_info[ '_run_class' ][0] ); ?>"/><br />

	<label for="run_time">Time</label>
	<input id="run_time" name="run_time" value="<?php esc_attr_e( $run_info[ '_run_time' ][0] ); ?>"/><br />

	<label for="run_winnings">Winnings</label>
	<input id="run_winnings" name="run_winnings" value="<?php esc_attr_e( $run_info[ '_run_winnings' ][0] ); ?>"/><br />

</div>