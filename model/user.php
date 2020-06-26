<?php

require_once( 'database.php' );

class User {

  protected $id;
  protected $email;
  protected $password;
  protected $key;

  public function __construct( $user = null ) {

    if( $user != null ):
      $this->setId( isset( $user->id ) ? $user->id : null );
      $this->setEmail( $user->email );
      $this->setPassword( $user->password, isset( $user->password_confirm ) ? $user->password_confirm : false );
    endif;
    
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/

  public function setId( $id ) {
    $this->id = $id;
  }

  public function setEmail( $email ) {

    if ( !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) < 3):
      throw new Exception( 'Email incorrect' );
    endif;

    $this->email = $email;

  }

  public function setPassword( $password, $password_confirm = false ) {

    if( $password_confirm && $password != $password_confirm ):
      throw new Exception( 'Vos mots de passes sont différents' );

    elseif($password_confirm && strlen($password) < 5):
      throw new Exception( 'Le mot de passe doit faire plus de 5 caractères' );

    endif;
    $this->password = $this->hash($password);
  }

  public function setKey($key) {
    $this->key = $key;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/

  public function getId() {
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getKey() {
    return $this->key;
  }

  /***********************************
  * -------- CREATE NEW USER ---------
  ************************************/

  public function createUser() {

    // Open database connection
    $db   = init_db();

    // Check if email already exist
    $req  = $db->prepare( "SELECT * FROM user WHERE email = ?" );
    $req->execute( array( $this->getEmail() ) );

    if( $req->rowCount() > 0 ) throw new Exception( "Email ou mot de passe incorrect" );

    // Insert new user
    $req->closeCursor();
    
    $this->setKey($this->generateKeyActivation()); # For generate a key activation
    
    $req  = $db->prepare( "INSERT INTO user ( email, password, activation ) VALUES ( :email, :password, :activation )" );
    $req->execute( array(
      'email'     => $this->getEmail(),
      'password'  => $this->getPassword(),
      'activation'       => $this->getKey()
    ));

    // Close databse connection
    $db = null;

  }

  /**************************************
  * -------- GET USER DATA BY ID --------
  ***************************************/

  public static function getUserById( $id ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE id = ? AND activation IS NULL" );
    $req->execute( array( $id ));

    // Close databse connection
    $db   = null;

    return $req->fetch(PDO::FETCH_ASSOC);
  }

  /***************************************
  * ------- GET USER DATA BY EMAIL -------
  ****************************************/

  public function getUserByEmail() {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE email = ? AND activation IS NULL" );
    $req->execute( array( $this->getEmail() ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  /**
   * hash a password with salt & sha256
   * Eg: 
   *  ThibaudEtRobin = my password
   *  Cut in two parti :
   *    - (1) First: the first 3 characters (Thi)
   *    - (2) Second: The rest of it (baudetRobin)
   * And the pattern salt is (2) + my password + (1)
   * Result : baudetRobinThibaudetRobinThi
   * @return string generated sha256 password
   */
  private function hash($password) {
    $begin_password = substr($password, 3, strlen($password));
    $end_password   = substr($password, 0,3);

    $salt = $begin_password.$password.$end_password;
    return hash('sha256', $salt);
  }

  /**
   * Generate random caracter for email confirmation
   *
   * @return string 10 caracters
   */
  private function generateKeyActivation() {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
    ceil(10/strlen($x)) )),1,10);

  }

  public static function activateAccount($key) {
    $db = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE activation = ?" );
    $req->execute( array( $key ));

    if( $req->rowCount() == 0 ) throw new Exception( "Le code d'activation est invalide ou inexistant." );

    $req->closeCursor();

    try {
      $req  = $db->prepare( "UPDATE user set activation = NULL WHERE activation = ?" );
      $req->execute( array( $key ));

    }catch(Exception $e) {
      throw new Exception("Problème lors de l'activation du compte.");
    }

  }

  public function updateEmail() {
    
    $db = init_db();

    $req = $db->prepare("UPDATE user SET email = :email WHERE id = :user_id");
    $req->execute(array(
      "email" => $this->getEmail(),
      "user_id"    => $this->getId()
    ));

    $req->closeCursor();

    $db = null;
  }

  public function updatePassword() {
    
    $db = init_db();

    $req = $db->prepare("UPDATE user SET user.password = :pwd WHERE id = :user_id");
    $req->execute(array(
      "pwd" => $this->getPassword(),
      "user_id"    => $this->getId()
    ));

    $req->closeCursor();

    $db = null;
  }


  public function deleteAccount() {
    
    $db = init_db();

    $req = $db->prepare("DELETE FROM user WHERE id = :user_id");
    $req->execute(array(
      "user_id"    => $this->getId()
    ));

    $req->closeCursor();

    $db = null;
  }

}
