<?php

function contact($post) {

    $contact = new stdClass();
    $contact->email = htmlentities($post['email']);
    $contact->subject = $post['subject'];
    $contact->message = $post['message'];


    try {
        if ( !filter_var($contact->email, FILTER_VALIDATE_EMAIL) || strlen($contact->email) < 3)
            throw new Exception("Email incorrecte");
        
        if(empty($contact->subject) || empty($contact->message))
            throw new Exception("Tous les champs sont obligatoire");


        mail("contact@codflix.com", "[CodFlix] ". $contact->subject, "Une personne tente de vous contacter depuis la page contact.
Adresse email: ".$contact->email."
Sujet: ".$contact->subject."

".$contact->message);

        $success_msg = "Votre message à bien été envoyé";
    
    }catch(Exception $e) {
        $error_msg = $e->getMessage();
    }

    require("view/contactView.php");


}

function contactPage() {
    $contact = new stdClass();

    if(isset($_SESSION["user_id"])) {
        $user_id = htmlentities($_SESSION["user_id"]);

        $user = user::getUserById($user_id);

        $email = $user["email"];

    }else {
        $email = '';
    }

    $contact->email = $email;
    $contact->subject = '';
    $contact->message = '';

    require("view/contactView.php");
}

?>