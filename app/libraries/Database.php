<?php

/**
 * PDO Database Class
 * connect to db
 * create prepared statements
 * bind values
 * return rows and results
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
        // set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true, // persistent connection 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // handle errors
        );

        // create PDO instance
        try {
            // database_handle
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error; // get the error message
        }
    }

    // prepare statement with query
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // public function getCodeById($id)
    // {
    //   $this->db->query('SELECT * FROM codes 
    //                     WHERE id = :id AND is_deleted=:is_deleted');
    //   $this->db->bind(':id', $id);
    //   $this->db->bind(':is_deleted', 0);

    //   return $this->db->single();
    // }

    /*
            bind values
            $statement->bindValue('calories', $calories, PDO::PARAM_INT);
            $statement->bindValue(':colour', $colour, PDO::PARAM_STR);
            check the type of the value, then set the type variable to the corresponding type
    */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // execute the prepared statement
    public function execute()
    {

        return $this->stmt->execute();
    }

    // get result set as array of objects
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // get single record as object
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // get row count
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
