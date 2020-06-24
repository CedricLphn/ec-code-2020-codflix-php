<?php

require_once( 'model/user.php' );

/****************************
* ----- LOAD SIGNUP PAGE -----
****************************/

function signupPage() {

  $user     = new stdClass();
  $user->id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

  if( !$user->id ):
    require('view/auth/signupView.php');
  else:
    require('view/homeView.php');
  endif;

}

/***************************
* ----- SIGNUP FUNCTION -----
***************************/

function signup($post) {

  $data = new stdClass();
  $data->email = htmlentities($post['email']);
  $data->password = htmlentities($post['password']);
  $data->password_confirm = htmlentities($post['password_confirm']);

  $error_msg = "";
  
  try {
    $user = new user($data);
    $user->createUser();
    $activation_link= CoreModel::getAbsoluteUrl()."?action=login&code=".$user->getKey();
    mail($user->getEmail(), "Activez votre compte sur Cod'Flix", "Bienvenue sur Cod'flix !
    
Vous êtes sur le point d'entrer dans la grande famille de Cod'Flix. Mais avant tout cela, vous devez activez votre compte en cliquant simplement sur ce lien:
".$activation_link."

A bientôt sur Cod'Flix !

L'équipe Cod'flix");
    $success_msg = "Un email contenant votre lien d'activation vient d'être envoyé !";
  }catch(Exception $e) {
    $error_msg = $e->getMessage();
    
  }
  
  require('view/auth/signupView.php');
}