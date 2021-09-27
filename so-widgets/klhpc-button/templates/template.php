<!-- KLHPC SOW BUTTON WIDGET -->
<?php
  $button_url  = !empty( $instance['btn_url'] ) ? $instance['btn_url'] : "#";
  $button_text = !empty( $instance['btn_text'] ) ? $instance['btn_text'] : "Button";
?>
<a href="<?php echo $button_url?>" class="klhpc-btn" data-behaviour="klhpcp_redirect_url_cookie">
  <?php _e( $button_text );?>
</a>
