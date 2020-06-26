<?php

require_once( 'model/CoreModel.php' );
require_once( 'model/Utils.php' );

/**************************
* --- AUTOLOAD CONTROLLER---
***************************/
$directory = "controller/";
if(is_dir($directory)) {
  $scan = scandir($directory);
  unset($scan[0], $scan[1]); //unset . and ..
  foreach($scan as $file) {
          if(strpos($file, 'Controller.php') !== false) {
              require_once($directory."/".$file);
          }
  }
}

/**************************
* ----- HANDLE ACTION -----
***************************/

if ( isset( $_GET['action'] ) ):

  switch( $_GET['action']):

    case 'login':

      if ( !empty( $_POST ) ) login( $_POST );
      elseif( !empty($_GET['code'] ) ) activation_code($_GET['code']);
      else loginPage();

    break;

    case 'signup':
      if( !empty( $_POST ) ) signup( $_POST );
      else signupPage();

    break;

    case 'watch':
      if(!isset($_SESSION['user_id'])) homePage();
      else watchPage();
    break;

    case 'watch':
      if(!isset($_SESSION['user_id'])) homePage();
      else watchPage();
    break;

    case 'profil':
      if(!isset($_SESSION['user_id'])) homePage();
      else profilPage(!empty($_POST) ? $_POST : null );
    break;

    case 'history':
      if(!isset($_SESSION['user_id'])) homePage();
      else historyPage();
    break;

    case 'logout':

      logout();

    break;

    case 'contact':
      if($_POST): contact( $_POST );
      else : contactPage();
      endif;
    
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
