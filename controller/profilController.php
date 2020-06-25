<?php
/**
 * J'ai un peu craqué sur la suppression du compte :(
 */


function profilPage($post = null) {
    $user_id = htmlentities($_SESSION["user_id"]);
    
    $user = user::getUserById($user_id);

    CoreModel::dd($post);

    if(isset($post["action"])):
        $action = htmlentities($post["action"]);
    else:
        $action = false;
    endif;

    switch($action):
        case 'email':
            changeEmail($post);
        break;
        case 'password':
            changePassword($post);
        break;
        default:
            require('view/profilView.php');
        break;

    endswitch;

}

function changeEmail($post) {
    $user_id = htmlentities($_SESSION["user_id"]);
    
    
    $login = new stdClass();
    $login->id = $user_id;
    $login->email = htmlentities($post["new_email"]);
    $login->password = null;
    
    
    try {
        $user = new User($login);

        if($user->getEmail() != $post["confirm_email"])
            throw new Exception("Les adresses email ne correspondent pas.");

        $user->updateEmail();
        
        $success_msg = "Votre adresse e-mail à été modifiée";
        
    }catch(Exception $e) {
        $error_msg = $e->getMessage();
    }
    
    $user = user::getUserById($user_id);
    require('view/profilView.php');

}

function changePassword($post) {
    $user_id = htmlentities($_SESSION["user_id"]);
    $user_info = user::getUserById($user_id);

    CoreModel::dd($user_info);

    try {
        
        $login = new stdClass();
        $login->id = $user_id;
        $login->email = $user_info["email"];
        $login->password = htmlentities($post["password"]);


        $user = new User($login);

        CoreModel::dd($user->getPassword());

        if($user_info["password"] != $user->getPassword())
            throw new Exception("Le mot de passe est incorrect");

        $user->setPassword(htmlentities($post["new_password"]), htmlentities($post["confirm"]));

        $user->updatePassword();
        
        $success_msg = "Votre mot de passe à été modifié";
        
    }catch(Exception $e) {
        $error_msg = $e->getMessage();
    }
    
    $user = user::getUserById($user_id);
    require('view/profilView.php');

}

?>