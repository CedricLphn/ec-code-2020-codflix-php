<?php

require_once( 'controller/coreController.php' );
require_once( 'controller/homeController.php' );
require_once( 'controller/loginController.php' );
require_once( 'controller/signupController.php' );
require_once( 'controller/mediaController.php' );

/**************************
* ----- HANDLE ACTION -----
***************************/

if ( isset( $_GET['action'] ) ):

  switch( $_GET['action']):

    case 'login':

      if ( !empty( $_POST ) ) login( $_POST );
      else loginPage();

    break;

    case 'signup':

      signupPage();

    break;

    case 'logout':

      logout();

    break;

  endswitch;

else:

  $user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;
  $media_id = isset($_GET['media']) ? htmlentities($_GET['media']) : false;

  if( $user_id && !$media_id){
    mediaPage();
  }else if($user_id && $media_id) {
    showMedia();
  }else {
    homePage();

  }

endif;
