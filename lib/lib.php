<?php

$inc_files = array(
  "class-klhpc-utils.php",
  "class-klhpc-plugin.php"
);

foreach( $inc_files as $inc_file ){
  require_once( $inc_file );
}
