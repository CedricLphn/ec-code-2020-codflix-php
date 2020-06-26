<?php
/**
 * WHEN A USER VALIDE A FORM
 *
 * @param array $post
 * @return void
 */
function profilPage($post = null) {
    $user_id = htmlentities($_SESSION["user_id"]);
    
    $user    = user::getUserById($user_id);

    /**
     * ROUTING 
     */
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
        case 'delete':
            deleteAccount($post); # Good bye my friend
        break;
        default:
            require('view/profilView.php');
        break;

    endswitch;

}

/**
 * CHANGE EMAIL
 *
 * @param array $post
 * @return void
 */
function changeEmail($post) {
    $user_id = htmlentities($_SESSION["user_id"]);
    
    
    $login           = new stdClass();
    $login->id       = $user_id;
    $login->email    = htmlentities($post["new_email"]);
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

/**
 * CHANGE PASSOWRD
 *
 * @param array $post
 * @return void
 */
function changePassword($post) {
    $user_id    = htmlentities($_SESSION["user_id"]);
    $user_info  = user::getUserById($user_id);

    try {
        
        $login           = new stdClass();
        $login->id       = $user_id;
        $login->email    = $user_info["email"];
        $login->password = htmlentities($post["password"]);


        $user = new User($login);

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

/**
 * J'ai un peu craqué sur la suppression du compte :(
 *
 * DELETE ACCOUNT
 *
 * @param array $post
 * @return void
 */
function deleteAccount($post) {
    $user_id    = htmlentities($_SESSION["user_id"]);
    $user_info  = user::getUserById($user_id);
    
    
    $login           = new stdClass();
    $login->id       = $user_id;
    $login->email    = $user_info["email"];
    $login->password = $post["delete_account"];
    
    
    try {
        $user = new User($login);

        if($user_info["password"] != $user->getPassword())
            throw new Exception("Le mot de passe ne correspond pas");
        
        $user->deleteAccount();

        header('Location: index.php?action=logout');
        
    }catch(Exception $e) {
        $error_msg = $e->getMessage();
    }
    
    $user = user::getUserById($user_id);
    require('view/profilView.php');
}

?>