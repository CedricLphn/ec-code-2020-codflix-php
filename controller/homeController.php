<?php

require_once( 'model/user.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function homePage() {

  $user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

  if( $user_id ):

    $user_data  = User::getUserById( $user_id );

    require('view/dashboardView.php');
  else:
    require('view/homeView.php');
  endif;

}
