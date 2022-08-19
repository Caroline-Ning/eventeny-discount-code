<?php
  class User {
    private $db;

    public function __construct(){
      // Database.php object in libraries
      $this->db = new Database;
    }

    // log user in
    public function login($email, $password){
        // find the user with the passed in email
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
  
        // a single user
        $row = $this->db->single();
  
        // the pswd in the database is a hashed pswd
        $hashed_password = $row->password;

        // see if : pswd in the database = pswd from input
        if(password_verify($password, $hashed_password)){
          // matches, return user obj
          return $row;
        } else {
          return false;
        }
    }
    
    // check if the email is already registered
    public function findUserByEmail($email){
      // prepare statement with query
      $this->db->query('SELECT * FROM users WHERE email = :email');

      // bind the passed in $email with the :email place holder
      $this->db->bind(':email', $email);

      // get single record as object
      $row = $this->db->single();

      // check if this single record exsist. If so, the email is already registered
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    public function register($data){
        // insert into database
        $this->db->query('INSERT INTO users (name, email, password, status) VALUES(:name, :email, :password,:status)');
        // bind user input with :placeholder
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':status', $data['status']);

        // see if successfully execute (after insert or delete)
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
  }