<?php

/**
 * Build the arena custom field meta boxes.
 *
 * @link       https://raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Strided_App
 * @subpackage Strided_App/admin/partials
 */
?>

<?php 

$arena_info = get_post_meta( get_the_ID() );

?>

<div class="arena-information">

	<input type="hidden" name="arena_information_meta_box_nonce" value="<?php esc_attr_e( wp_create_nonce('arena_information_meta_box_nonce') ); ?>" />

	<label for="arena_address">Address</label>
	<textarea id="arena_address" name="arena_address"><?php esc_attr_e( $arena_info[ '_arena_address' ][0] ); ?></textarea><br />

</div>