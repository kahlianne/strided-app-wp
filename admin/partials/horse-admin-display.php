<?php

/**
 * Build the horse custom field meta boxes.
 *
 * @link       https://raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Strided_App
 * @subpackage Strided_App/admin/partials
 */
?>

<?php 

$horse_info = get_post_meta( get_the_ID() );

?>

<div class="horse-information">

	<input type="hidden" name="horse_information_meta_box_nonce" value="<?php esc_attr_e( wp_create_nonce('horse_information_meta_box_nonce') ); ?>" />

	<label for="horse_registered_name">Registered Name</label>
	<input id="horse_registered_name" name="horse_registered_name" value="<?php esc_attr_e( $horse_info[ '_horse_registered_name' ][0] ); ?>" /><br />

	<label for="horse_year_born">Year Born</label>
	<input id="horse_year_born" name="horse_year_born" value="<?php esc_attr_e( $horse_info[ '_horse_year_born' ][0] ); ?>"/><br />

	<label for="horse_gender">Gender</label>
	<select id="horse_gender" name="horse_gender">
		<option disabled value hidden <?php if ('' == $horse_info[ '_horse_gender' ][0]) { echo 'selected'; } ?> ></option>
		<option value="gelding" <?php if ('gelding' == $horse_info[ '_horse_gender' ][0]) { echo 'selected'; } ?> >Gelding</option>
		<option value="stud" <?php if ('stud' == $horse_info[ '_horse_gender' ][0]) { echo 'selected'; } ?> >Stud</option>
		<option value="mare" <?php if ('mare' == $horse_info[ '_horse_gender' ][0]) { echo 'selected'; } ?> >Mare</option>
	</select><br />

</div>