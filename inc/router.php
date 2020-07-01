<?php

$do = $_POST['do'];

if ( empty( $do ) ) {
  echo 'No $_POST["do"] parameter specified. :(';
  http_response_code(400);
  wp_die();
}

$do();

wp_die();
