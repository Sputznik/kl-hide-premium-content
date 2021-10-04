<!-- KLHPC SOW BUTTON WIDGET -->
<?php
  $widget_id   = 'sow-klhpc-btn-'.KLHPC_UTILS::klhpcUniqueID( $instance );
  $button_url  = !empty( $instance['btn_url'] ) ? $instance['btn_url'] : "#";
  $button_text = !empty( $instance['btn_text'] ) ? $instance['btn_text'] : "Button";
?>
<a href="<?php echo $button_url?>" id="<?php _e( $widget_id );?>" class="klhpc-btn" data-behaviour="klhpc_redirect_url_cookie">
  <?php _e( $button_text );?>
</a>

<style media="screen">
  <?php _e( '#'.$widget_id );?>.klhpc-btn{
    color: <?php echo( $instance['btn_text_color'] ? $instance['btn_text_color'] : "#e6e6e6" );?> !important;
    background-color: <?php echo( $instance['btn_bg_color'] ? $instance['btn_bg_color'] : "#1a8917" );?>;
  }

  @media (min-width: 769px){
    <?php _e( '#'.$widget_id );?>.klhpc-btn:hover{
      opacity: 0.9;
    }
  }

</style>
