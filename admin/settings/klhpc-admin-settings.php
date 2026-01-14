<div class="wrap">
	<h1>KL IP Settings</h1>
<?php

if( isset( $_POST['list_ips'] ) && is_array( $_POST['list_ips'] ) && count( $_POST['list_ips'] ) ){
  $ip_ranges = array();

	foreach( $_POST['list_ips'] as $list_ip ){

		// SANITIZE IP_LABEL AND DECODE HTML-ENTITIES TO IT'S CHARACTER REPRESENTATION
		$ip_label = isset( $list_ip['label'] ) && !empty( $list_ip['label'] ) ? html_entity_decode( sanitize_textarea_field( $list_ip['label'] ) ) : '';

		// SANITIZE IP_RANGE
		$ip_range	= isset( $list_ip['range'] ) && !empty( $list_ip['range'] ) ? sanitize_text_field( $list_ip['range'] ) : '';

		array_push( $ip_ranges, array( 'label' => $ip_label, 'range' => $ip_range ) );
  }

  $settings = $this->get_settings();
	$settings['klhpc']['ip_ranges'] = wp_unslash( $ip_ranges );
  $this->write_settings( $settings );
  $this->show_update_notice("Settings Saved");

}

$settings = $this->get_settings();

$fields = array(
  'range'	=> array(
    'type'	=> 'text',
    'text'	=> 'Enter the IP Range',
  )
);

$rows = array();

if( isset( $settings['klhpc']['ip_ranges'] ) && is_array( $settings['klhpc']['ip_ranges'] ) && count( $settings['klhpc']['ip_ranges'] ) ){
  foreach( $settings['klhpc']['ip_ranges'] as $ip_range ){

		if( is_array( $ip_range ) ){
			array_push( $rows, array( 'range' => $ip_range['range'], 'label' =>  $ip_range['label'] ) );
		} else {
			// NOTE:
			// THIS BLOCK WILL NOT BE INVOKED AFTER THE DATA HAS BEEN SAVED AT LEAST ONCE WITH THE UPDATED DATA STRUCTURE
			// SO, IT CAN BE REMOVED AFTER THAT.
			array_push( $rows, array( 'range' => $ip_range ) );
		}

  }
}
?>
  <form method="POST">
    <div data-behaviour="klhpc-repeater" data-slug="list_ips" data-fields='<?php echo json_encode( $fields );?>'>
			<div id="klhpc-form-alert"></div>
    	<div data-behaviour="klhpc-repeater-rows" style="display:none;"><?php echo json_encode( $rows ); ?></div>
    </div>
  	<p class='submit'><input type="submit" name="submit" class="button button-primary" value="Save Changes"/><p>
  </form>
</div>

<style>
	label{
		display: block;
		margin-bottom: 10px;
	}
	.orbit-choice-item{
		background: #fff;
		margin-bottom: 15px;
		position: relative;
		padding: 10px;
		padding-bottom: 0;
	}
	.orbit-choice-item .list-content{ padding-bottom: 10px; }
  .orbit-field { margin-top: 10px; }
	#orbit-choices-list .orbit-ip-field-alert{ border:0;color:#d63638;margin:0 -10px;font-weight:600; }
</style>
