<div class="wrap">
	<h1>KL IP Settings</h1>
<?php

if( isset( $_POST['list_ips'] ) && is_array( $_POST['list_ips'] ) && count( $_POST['list_ips'] ) ){
  $ip_ranges = array();

  foreach( $_POST['list_ips'] as $list_ip ){
    $range = $list_ip['range'];
    if( $range ){ array_push( $ip_ranges, $range ); }
  }

  $settings = $this->get_settings();
  $settings['klhpc']['ip_ranges'] = $ip_ranges;
  $this->write_settings( $settings );
  $this->show_update_notice("Settings Saved");

}

$settings = $this->get_settings();

$fields = array(
  'range'	=> array(
    'type'	=> 'text',
    'text'	=> 'Enter the IP Range'
  )
);

$rows = array();

if( isset( $settings['klhpc']['ip_ranges'] ) && is_array( $settings['klhpc']['ip_ranges'] ) && count( $settings['klhpc']['ip_ranges'] ) ){
  foreach( $settings['klhpc']['ip_ranges'] as $range ){
    array_push( $rows, array( 'range' => $range ) );
  }
}

?>

  <form method="POST">
    <div data-behaviour="klhpc-repeater" data-slug="list_ips" data-rows='<?php echo json_encode( $rows );?>' data-fields='<?php echo json_encode( $fields );?>'></div>
  	<p class='submit'><input type="submit" name="submit" class="button button-primary" value="Save Changes"><p>
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
</style>
