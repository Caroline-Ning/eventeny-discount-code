<?php
class UserCode
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function addUserWithCode($user_id, $code_id)
    {
        // prepare statement
        $this->db->query('INSERT INTO user_code (user_id,code_id) VALUES(:user_id,:code_id)');

        // bind $data with placeholder
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':code_id', $code_id);

        // execute, return t/f
        return $this->db->execute();
    }

    public function userExistsForThisCode($user_id, $code_id)
    {
        $this->db->query('SELECT * FROM user_code 
        WHERE user_id = :user_id AND code_id=:code_id');

        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':code_id', $code_id);

        return $this->db->single();
    }
};
